<?php

namespace AppBundle\DataFixtures\ORM;

use Faker\Factory;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;
use Nelmio\Alice\Loader\FakerProvider;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AppFixtures extends DataFixtureLoader
{
    private $startDateTime;

    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    protected function getProcessors()
    {
        return array(
            new PictureProcessor()
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return  array(
            __DIR__ . '/images.yml',
            __DIR__ . '/businesses.yml',
            __DIR__ . '/services.yml',
            __DIR__ . '/employees.yml',
            __DIR__ . '/customers.yml',
            __DIR__ . '/bookings.yml',
        );
    }

    public function getStartDateTime()
    {
        return $this->startDateTime = $this->faker->dateTimeBetween('now', '7 days');
    }

    public function getEndDateTime()
    {
        $endDateTime = clone $this->startDateTime;
        $endDateTime = $endDateTime->modify('+30 minutes');
        return $endDateTime;
    }

    public function employeePicture()
    {
        $filenames = array(
            'charles.jpg',
            'sylvia.jpg'
        );
        return $filenames[array_rand($filenames)];
    }

    public function businessImage()
    {

        $projectRoot = __DIR__.'/../../../..';
        $filenames = array(
            'shop.jpg'
        );

        return new UploadedFileForFixture($projectRoot. '/resources/'. $filenames[array_rand($filenames)], $filenames[array_rand($filenames)], null, null, true);

    }
}

class UploadedFileForFixture extends UploadedFile
{
    public function move($directory, $name = null)
    {
        $target = $this->getTargetFile($directory, $name);
        $fs = new Filesystem();
        $fs->copy(
            $this->getPathname(),
            $target,
            true
        );

        @chmod($target, 0666 & ~umask());

        return $target;

    }
}
