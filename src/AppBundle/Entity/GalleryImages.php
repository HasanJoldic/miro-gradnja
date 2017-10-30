<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GalleryImages
 *
 * @ORM\Table(name="gallery_images")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GalleryImagesRepository")
 */
class GalleryImages
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Date", inversedBy="variables")
     * @ORM\JoinColumn(name="date_id", referencedColumnName="id", unique=true)
     */
    private $date;

    /**
     * @var array
     *
     * @ORM\Column(name="images", type="json_array")
     */
    private $images;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages(array $images)
    {
        $this->images = $images;
    }
}

