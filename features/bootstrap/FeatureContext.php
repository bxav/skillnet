<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements KernelAwareContext, SnippetAcceptingContext
{

    /**
     * @Given :firstname propose:
     */
    public function propose($firstname, \Behat\Gherkin\Node\TableNode $table)
    {
        /**
         * @var Doctrine\ORM\EntityManager $em
         */
        $em = $this->getService('doctrine.orm.entity_manager');
        $employee = $em->getRepository("AppBundle:Employee")->findOneByFirstName($firstname);
        foreach($table->getRow(0) as $row) {
            var_dump($row);
            $service = $em->getRepository("AppBundle:Service")->findOneByType($row);

            var_dump($service->getType());
            $employee->addService($service);
        }
        $em->persist($employee);
        $em->flush();
    }


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given l'employee :arg1 travaile le :arg2 de :arg3 à :arg4
     */
    public function lEmployeeTravaileLeDeA($arg1, $arg2, $arg3, $arg4)
    {
        /**
         * @var Doctrine\ORM\EntityManager $em
         */
        $em = $this->getService('doctrine.orm.entity_manager');
        $employee = $em->getRepository("AppBundle:Employee")->findOneByUsername($arg1);
        $employee->setWorkingHoursByDay($arg2, [$arg3, $arg4]);
        $em->persist($employee);
        $em->flush();;
    }

    /**
     * @Given the business :arg1 works from :arg2 to :arg3 at :arg4
     */
    public function lBusinessTravaileLeDeA($arg1, $arg2, $arg3, $arg4)
    {
        /**
         * @var Doctrine\ORM\EntityManager $em
         */
        $em = $this->getService('doctrine.orm.entity_manager');
        $business = $em->getRepository("AppBundle:Business")->findOneBySlug($arg1);
        $business->setWorkingHoursByDay($arg2, [$arg3, $arg4]);
        $em->persist($business);
        $em->flush();;
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

    /**
     * @BeforeScenario
     */
    public function purgeDatabase()
    {
        $entityManager = $this->getService('doctrine.orm.entity_manager');
        $purger = new ORMPurger($entityManager);
        $purger->purge();

        $entityManager = $this->getService('doctrine.orm.entity_manager');
        $entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $isMySqlDriver = $entityManager->getConnection()->getDriver() instanceof PDOMySqlDriver;
        if ($isMySqlDriver) {
            $entityManager->getConnection()->executeUpdate("SET foreign_key_checks = 0;");
        }
        $purger = new ORMPurger($entityManager);
        $purger->purge();
        if ($isMySqlDriver) {
            $entityManager->getConnection()->executeUpdate("SET foreign_key_checks = 1;");
        }
        $entityManager->clear();
    }


    /**
     * @BeforeScenario
     */
    static public function suppressDepreciationNotices(\Behat\Behat\Hook\Scope\BeforeScenarioScope $scope)
    {
        error_reporting(E_ALL ^ E_NOTICE);
    }
}
