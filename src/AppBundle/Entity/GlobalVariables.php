<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GlobalVariables
 *
 * @ORM\Table(name="global_variables")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GlobalVariablesRepository")
 */
class GlobalVariables
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
     * @ORM\Column(name="page_title", type="text", nullable=false)
     */
    private $pageTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="favicon_image", type="text", nullable=false)
     */
    private $faviconImage;

    /**
     * @var string
     *
     * @ORM\Column(name="brand_image", type="text", nullable=false)
     */
    private $brandImage;

    /**
     * @var string
     *
     * @ORM\Column(name="footer_text", type="text", nullable=false)
     */
    private $footerText;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", nullable=false)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="second_phone_number", type="string", nullable=false)
     */
    private $secondPhoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Date", inversedBy="variables")
     * @ORM\JoinColumn(name="date_id", referencedColumnName="id", unique=true)
     */
    private $date;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }

    /**
     * @param string $pageTitle
     */
    public function setPageTitle(string $pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return string
     */
    public function getFaviconImage(): string
    {
        return $this->faviconImage;
    }

    /**
     * @param string $faviconImage
     */
    public function setFaviconImage(string $faviconImage)
    {
        $this->faviconImage = $faviconImage;
    }

    /**
     * @return string
     */
    public function getBrandImage(): string
    {
        return $this->brandImage;
    }

    /**
     * @param string $brandImage
     */
    public function setBrandImage(string $brandImage)
    {
        $this->brandImage = $brandImage;
    }

    /**
     * @return string
     */
    public function getFooterText(): string
    {
        return $this->footerText;
    }

    /**
     * @param string $footerText
     */
    public function setFooterText(string $footerText)
    {
        $this->footerText = $footerText;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getSecondPhoneNumber()
    {
        return $this->secondPhoneNumber;
    }

    /**
     * @param mixed $secondPhoneNumber
     */
    public function setSecondPhoneNumber($secondPhoneNumber)
    {
        $this->secondPhoneNumber = $secondPhoneNumber;
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

}

