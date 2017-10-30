<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AboutUs
 *
 * @ORM\Table(name="about_us")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AboutUsRepository")
 */
class AboutUs
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
     * @var string
     *
     * @ORM\Column(name="about_us_title", type="string")
     */
    private $aboutUsTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="about_us_text", type="text")
     */
    private $aboutUsText;


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
     * @return string
     */
    public function getAboutUsTitle(): string
    {
        return $this->aboutUsTitle;
    }

    /**
     * @param string $aboutUsTitle
     */
    public function setAboutUsTitle(string $aboutUsTitle)
    {
        $this->aboutUsTitle = $aboutUsTitle;
    }

    /**
     * @return string
     */
    public function getAboutUsText(): string
    {
        return $this->aboutUsText;
    }

    /**
     * @param string $aboutUsText
     */
    public function setAboutUsText(string $aboutUsText)
    {
        $this->aboutUsText = $aboutUsText;
    }
}

