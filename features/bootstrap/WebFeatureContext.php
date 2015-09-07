<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Behat\Tester\Exception\PendingException;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Defines application features from the specific context.
 */
class WebFeatureContext implements SnippetAcceptingContext
{

    /**
     * @var \Knp\FriendlyContexts\Context\MinkContext $minkContext
     */
    private $minkContext;


    /** @BeforeScenario */
    public function gatherContexts(\Behat\Behat\Hook\Scope\BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->minkContext = $environment->getContext('Knp\FriendlyContexts\Context\MinkContext');
    }

    /**
     * @Given que je suis sur la page des disponibilités
     */
    public function queJeSuisSurLaPageDesDisponibilites()
    {
        $this->minkContext->visit('/');
    }

    /**
     * @Given une liste de prestataires m'est proposé suite à une recherche
     */
    public function uneListeDePrestatairesMEstProposeSuiteAUneRecherche()
    {
        //@todo
    }


    /**
     * @When quand je clique sur un prestataire :arg1
     */
    public function quandJeCliqueSurUnPrestataire($arg1)
    {
        $this->minkContext->clickLinkContaining($arg1);
    }

    /**
     * @Then je suis sur la page du professionnel :arg1
     */
    public function jeSuisSurLaPageDuProfessionnel($arg1)
    {
        $slugifer = new \Cocur\Slugify\Slugify();
        $this->minkContext->assertPageAddress('/'. $slugifer->slugify($arg1));
    }

    /**
     * @Then je devrais voir les informations sur le salon
     */
    public function jeDevraisVoirLesInformationsSurLeSalon()
    {
        throw new PendingException();
    }

    /**
     * @Then je devrais voir ma demande de disponibilité surlignée sur un calendrier
     */
    public function jeDevraisVoirMaDemandeDeDisponibiliteSurligneeSurUnCalendrier()
    {
        throw new PendingException();
    }

}
