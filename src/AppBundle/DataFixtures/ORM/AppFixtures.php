<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Image;
use Faker\Factory;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Finder\Finder;

class AppFixtures extends DataFixtureLoader
{
    private $startDateTime;

    private $faker;

    protected $path = '/../../../../resources/';

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    protected function getProcessors()
    {
        return [
          //  new ImageProcessor()
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtures()
    {
        return  array(
            __DIR__.'/businesses.yml',
            __DIR__.'/services.yml',
            __DIR__.'/users.yml',
            __DIR__.'/employees.yml',
            __DIR__.'/customers.yml',
            __DIR__.'/bookings.yml',
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

    public function employeeImage()
    {
        $filenames = array(
            'charles',
            'sylvia',
        );

        return $this->getAndUploadRandomImage($filenames);
    }

    public function businessImage()
    {
        $filenames = array(
            'shop',
        );

        return $this->getAndUploadRandomImage($filenames);
    }

    protected function getAndUploadRandomImage($filenames)
    {
        $finder = new Finder();
        $uploader = $this->container->get('app.image_uploader');

        $images = [];

        foreach ($finder->files()->in(__DIR__.$this->path) as $img) {
            $images[$img->getBasename('.jpg')] = $img;
        }

        $img = $images[$filenames[array_rand($filenames)]];
        $image = new Image();
        $image->setFile(new UploadedFile($img->getRealPath(), $img->getFilename()));
        $uploader->upload($image);

        return $image;
    }
}
