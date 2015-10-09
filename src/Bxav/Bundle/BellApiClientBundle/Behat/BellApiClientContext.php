<?php
namespace Bxav\Bundle\BellApiClientBundle\Behat;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\KernelInterface;


class BellApiClientContext extends RawMinkContext implements KernelAwareContext, SnippetAcceptingContext
{
    private $response = null;

    public function __construct($apiUrl, $userId, $apiKey)
    {
        $this->apiBase = [
            'apiUrl' => $apiUrl,
            'userId' => $userId,
            'apiKey' => $apiKey
        ];
    }

    /**
     * @Given I have a bellapi account
     */
    public function iHaveABellApiAccount()
    {
        return true;
    }

    /**
     * @When I search for business
     */
    public function iSearchForBusiness()
    {
        $this->response = $this->getService('bxav_bellapi_client.client')->get('businesses');
    }

    /**
     * @Then It should print businesses
     */
    public function iShouldAListOfBusiness()
    {
        echo $this->response;
    }


    /**
     * @var KernelInterface
     */
    protected $kernel;
    
    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Get service by id.
     *
     * @param string $id
     *
     * @return object
     */
    protected function getService($id)
    {
        return $this->getContainer()->get($id);
    }
    
    /**
     * Returns Container instance.
     *
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }
}
