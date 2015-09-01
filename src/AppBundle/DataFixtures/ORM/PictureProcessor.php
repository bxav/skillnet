<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Business;
use AppBundle\Entity\Employee;
use Nelmio\Alice\ProcessorInterface;
use Symfony\Component\Filesystem\Filesystem;

class PictureProcessor implements ProcessorInterface
{
    /**
     * Processes an object before it is persisted to DB
     *
     * @param object $object instance to process
     */
    public function preProcess($object)
    {
        if (!$object instanceof Business and !$object instanceof Employee) {
            return;
        }

        if (!$object->getMainPictureFilename()) {
            return;
        }

        $projectRoot = __DIR__.'/../../../..';
        $targetFilename = 'fixtures_'.mt_rand(0, 100000).'.jpg';
        $fs = new Filesystem();
        $fs->copy(
            $projectRoot.'/resources/'.$object->getMainPictureFilename(),
            $projectRoot.'/web/uploads/pictures/'.$targetFilename,
            true
        );

        $object->setMainPictureFilename($targetFilename);
    }

    /**
     * Processes an object before it is persisted to DB
     *
     * @param object $object instance to process
     */
    public function postProcess($object)
    {
        // TODO: Implement postProcess() method.
    }
}