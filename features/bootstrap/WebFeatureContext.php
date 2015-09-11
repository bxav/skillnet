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
     * @Given je suis loguer entant que :username
     */
    public function jeSuisLoguerEntantQue($username)
    {
        $this->minkContext->visit('/login');
        $this->minkContext->fillField('username', $username);
        $this->minkContext->fillField('password', $username);
        $this->minkContext->clickElement('_submit', 'button');

    }


    /**
     * @Given je suis sur la page du professionnel :arg1
     */
    public function jeSuisSurLaPageDuProfessionnel($arg1)
    {
        $slugifer = new \Cocur\Slugify\Slugify();
        $this->minkContext->visit('/'. $slugifer->slugify($arg1));
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
     * @Then je devrais être sur la page du professionnel :arg1
     */
    public function jeDevraisEtreSurLaPageDuProfessionnel($arg1)
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

    /**
     * @Given je suis sur la page du professionnel :arg1 et que je recherche un rendez-vous pour une :arg2, le :arg3
     */
    public function jeSuisSurLaPageDuProfessionnelEtQueJeRechercheUnRendezVousPourUne($arg1, $arg2, $arg3)
    {

        $slugifer = new \Cocur\Slugify\Slugify();
        $this->minkContext->visit('/'. $slugifer->slugify($arg1)."?service=$arg2&date=$arg3");
    }


    /**
     * @When je clique sur :arg1 dans le calendrier
     */
    public function jeCliqueSurDansLeCalendrier($arg1)
    {
        $this->minkContext->clickLinkContaining($arg1);
    }

    /**
     * @When que je clique sur le bouton réserver
     */
    public function queJeCliqueSurLeBoutonReserver()
    {
        throw new PendingException();
    }

    /**
     * @Then je vois l’ensemble des données récapitulative apparaît à l’écran (Nom salon,, adresse, soin, date, horaire et employé) avec un bouton validé.
     */
    public function jeVoisLEnsembleDesDonneesRecapitulativeApparaitALEcranNomSalonAdresseSoinDateHoraireEtEmployeAvecUnBoutonValide()
    {
        throw new PendingException();
    }

    /**
     * @Then je suis redirigée vers la page d’inscription (pour un non inscrit) ou je rentre directement sur ma page de profil particulier avec le rendez-vous inscrit sur celle-ci
     */
    public function jeSuisRedirigeeVersLaPageDInscriptionPourUnNonInscritOuJeRentreDirectementSurMaPageDeProfilParticulierAvecLeRendezVousInscritSurCelleCi()
    {
        throw new PendingException();
    }


}
