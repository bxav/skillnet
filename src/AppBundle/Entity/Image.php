<?php

namespace AppBundle\Entity;

use AppBundle\Model\ImageInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Image implements ImageInterface
{
    /**
     * Id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * File
     *
     * @var \SplFileInfo
     */
    protected $file;

    /**
     * Path to file
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $path;

    protected $host;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFile()
    {
        return null !== $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile()
    {
        return $this->file;
    }

    /**     * {@inheritdoc}
     */
    public function setFile(\SplFileInfo $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPath()
    {
        return null !== $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getRealPath()
    {
        return $this->host .'/'. $this->getPath();
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }
}
