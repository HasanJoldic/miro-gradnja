<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceRepository")
 */
class Service
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
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Date", inversedBy="variables")
     * @ORM\JoinColumn(name="date_id", referencedColumnName="id")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string")
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description_title", type="string")
     */
    private $descriptionTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @ORM\Column(name="list_title", type="string", nullable=true)
     */
    private $listTitle;

    /**
     * @var array
     *
     * @ORM\Column(name="list", type="array", nullable=true)
     */
    private $list;

    /**
     * @var string
     *
     * @ORM\Column(name="main_image", type="text")
     */
    private $mainImage;

    /**
     * @var array
     *
     * @ORM\Column(name="images", type="json_array")
     */
    private $images;

    /**
     * @var int
     *
     * @ORM\Column(name="place_in_list", type="integer")
     */
    private $placeInList;

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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getDescriptionTitle(): string
    {
        return $this->descriptionTitle;
    }

    /**
     * @param string $descriptionTitle
     */
    public function setDescriptionTitle(string $descriptionTitle)
    {
        $this->descriptionTitle = $descriptionTitle;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     */
    public function getListTitle()
    {
        return $this->listTitle;
    }

    /**
     */
    public function setListTitle($listTitle)
    {
        $this->listTitle = $listTitle;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param array $list
     */
    public function setList(array $list)
    {
        $this->list = $list;
    }

    /**
     * @return string
     */
    public function getMainImage(): string
    {
        return $this->mainImage;
    }

    /**
     * @param string $mainImage
     */
    public function setMainImage(string $mainImage)
    {
        $this->mainImage = $mainImage;
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

    /**
     * @return int
     */
    public function getPlaceInList(): int
    {
        return $this->placeInList;
    }

    /**
     * @param int $placeInList
     */
    public function setPlaceInList(int $placeInList)
    {
        $this->placeInList = $placeInList;
    }
}

