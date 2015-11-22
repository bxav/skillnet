<?php

use Knp\FriendlyContexts\Context\ApiContext;
use Behat\Gherkin\Node\PyStringNode;

class ApiFeatureContext extends ApiContext
{

    protected $scope;

    protected $responsePayload;

    /**
     * @Given /^assign to "([^"]*)" authorization roles:?$/
     */
    public function assignToAuthorizationRoles($username, \Behat\Gherkin\Node\TableNode $roles)
    {

        shell_exec("app/console sylius:rbac:initialize");
        $this->container->set('sylius.authorization_checker.default', null);
        $user = $this->get('app.repository.user')->findOneByUsername($username);
        $this->assignAuthorizationRoles($user, $roles->getColumn(0));
    }

    /**
     * @Given /^I specified the following request oauth2 credentials:?$/
     */
    public function iSpecifiedTheFollowingOauth2Credentials(\Behat\Gherkin\Node\TableNode $credentialsTable)
    {
        $clientCredential = $this->get('app.oauth2.client_creator')->create();
        //$clientCredential = json_decode($clientCredential);

        $config = array(
            'token_url' => 'http://localhost:8000/oauth/v2/token',
            'username' => $credentialsTable->getRowsHash()['username'],
            'password' => $credentialsTable->getRowsHash()['password'],
            'client_id' => $clientCredential['publicId'],
            'client_secret' => $clientCredential['secret']
        );
        $this
            ->getRequestBuilder()
            ->setCredentials($config)
            ->addSecurityExtension(new Oauth2Extension)
        ;
    }

    /**
     * @Then /^print the last response$/
     */
    public function printTheLastResponse()
    {
        echo $this->getResponse();
    }

    /**
     * @Given /^scope into the first element$/
     */
    public function scopeIntoTheFirstElement()
    {
        $this->scope = "array";
    }

    /**
     * @Given /^scope into the first "([^"]*)" property$/
     */
    public function scopeIntoTheFirstProperty($scope)
    {
        $this->scope = "{$scope}.0";
    }
    /**
     * @Given /^scope into the "([^"]*)" property$/
     */
    public function scopeIntoTheProperty($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @Given /^the properties exist:$/
     */
    public function thePropertiesExist(PyStringNode $propertiesString)
    {
        foreach (explode("\n", (string) $propertiesString) as $property) {
            $this->thePropertyExists($property);
        }
    }

    /**
     * @Given /^the "([^"]*)" property exists$/
     */
    public function thePropertyExists($property)
    {
        $payload = $this->getScopePayload();

        $message = sprintf(
            'Asserting the [%s] property exists in the scope [%s]: %s',
            $property,
            $this->scope,
            json_encode($payload)
        );

        /**
         * @var Knp\FriendlyContexts\Utils\Asserter $asserter
         */
        $asserter = $this->getAsserter();
        if (is_object($payload)) {
            $asserter->assert(array_key_exists($property, get_object_vars($payload)), $message);
        } else if (is_array($payload)){
            $asserter->assert(array_key_exists($property, $payload), $message);
        } else {
            throw new \Exception("No property inside this object");
        }
    }

    /**
     * @Given /^reset scope$/
     */
    public function resetScope()
    {
        $this->scope = null;
    }

    /**
     * Return the response payload from the current response.
     *
     * @return  mixed
     */
    protected function getResponsePayload()
    {
        if (! $this->responsePayload) {
            $json = json_decode($this->getResponse()->getBody(true));
            if (json_last_error() !== JSON_ERROR_NONE) {
                $message = 'Failed to decode JSON body ';
                switch (json_last_error()) {
                    case JSON_ERROR_DEPTH:
                        $message .= '(Maximum stack depth exceeded).';
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        $message .= '(Underflow or the modes mismatch).';
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        $message .= '(Unexpected control character found).';
                        break;
                    case JSON_ERROR_SYNTAX:
                        $message .= '(Syntax error, malformed JSON).';
                        break;
                    case JSON_ERROR_UTF8:
                        $message .= '(Malformed UTF-8 characters, possibly incorrectly encoded).';
                        break;
                    default:
                        $message .= '(Unknown error).';
                        break;
                }
                throw new \Exception($message);
            }
            $this->responsePayload = $json;
        }
        return $this->responsePayload;
    }

    /**
     * Returns the payload from the current scope within
     * the response.
     *
     * @return mixed
     */
    protected function getScopePayload()
    {
        $payload = $this->getResponsePayload();
        if (! $this->scope) {
            return $payload;
        } elseif ($this->scope == "array"){
            return $payload[0];
        }
        return $this->arrayGet($payload, $this->scope);
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @copyright   Taylor Otwell
     * @link        http://laravel.com/docs/helpers
     * @param       array   $array
     * @param       string  $key
     * @param       mixed   $default
     * @return      mixed
     */
    protected function arrayGet($array, $key)
    {
        if (is_null($key)) {
            return $array;
        }
        // if (isset($array[$key])) {
        //     return $array[$key];
        // }
        foreach (explode('.', $key) as $segment) {
            if (is_object($array)) {
                if (! isset($array->{$segment})) {
                    return;
                }
                $array = $array->{$segment};
            } elseif (is_array($array)) {
                if (! array_key_exists($segment, $array)) {
                    return;
                }
                $array = $array[$segment];
            }
        }
        return $array;
    }



    /**
     * @param array         $authorizationRoles
     * @param UserInterface $user
     */
    protected function assignAuthorizationRoles(\AppBundle\Entity\User $user, array $authorizationRoles = array())
    {
        foreach ($authorizationRoles as $role) {
            try {
                $authorizationRole = $this->get('sylius.repository.role')->findOneByName($role);
            } catch (\InvalidArgumentException $exception) {
                $authorizationRole = $this->createAuthorizationRole($role);
                $this->get('doctrine.orm.entity_manager')->persist($authorizationRole);
            }
            $user->addAuthorizationRole($authorizationRole);
        }
    }


    /**
     * @param string $role
     *
     * @return RoleInterface
     */
    protected function createAuthorizationRole($role)
    {
        $authorizationRole = $this->get('sylius.repository.role')->createNew();
        $authorizationRole->setCode($role);
        $authorizationRole->setName(ucfirst($role));
        $authorizationRole->setSecurityRoles(array('ROLE_ADMINISTRATION_ACCESS'));
        return $authorizationRole;
    }

}
