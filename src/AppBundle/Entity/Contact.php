<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="contact_company_title", type="string")
     */
    private $contactCompanyTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="address_first_line", type="string")
     */
    private $addressFirstLine;

    /**
     * @var string
     *
     * @ORM\Column(name="address_second_line", type="string")
     */
    private $addressSecondLine;

    /**
     * @var string
     *
     * @ORM\Column(name="address_third_line", type="string")
     */
    private $addressThirdLine;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_phone_number", type="string")
     */
    private $contactPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string")
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_company_description", type="text")
     */
    private $contactCompanyDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_facebook_link", type="string")
     */
    private $contactFacebookLink;


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
    public function getContactCompanyTitle(): string
    {
        return $this->contactCompanyTitle;
    }

    /**
     * @param string $contactCompanyTitle
     */
    public function setContactCompanyTitle(string $contactCompanyTitle)
    {
        $this->contactCompanyTitle = $contactCompanyTitle;
    }

    /**
     * @return string
     */
    public function getAddressFirstLine(): string
    {
        return $this->addressFirstLine;
    }

    /**
     * @param string $addressFirstLine
     */
    public function setAddressFirstLine(string $addressFirstLine)
    {
        $this->addressFirstLine = $addressFirstLine;
    }

    /**
     * @return string
     */
    public function getAddressSecondLine(): string
    {
        return $this->addressSecondLine;
    }

    /**
     * @param string $addressSecondLine
     */
    public function setAddressSecondLine(string $addressSecondLine)
    {
        $this->addressSecondLine = $addressSecondLine;
    }

    /**
     * @return string
     */
    public function getAddressThirdLine(): string
    {
        return $this->addressThirdLine;
    }

    /**
     * @param string $addressThirdLine
     */
    public function setAddressThirdLine(string $addressThirdLine)
    {
        $this->addressThirdLine = $addressThirdLine;
    }

    /**
     * @return string
     */
    public function getContactPhoneNumber(): string
    {
        return $this->contactPhoneNumber;
    }

    /**
     * @param string $contactPhoneNumber
     */
    public function setContactPhoneNumber(string $contactPhoneNumber)
    {
        $this->contactPhoneNumber = $contactPhoneNumber;
    }

    /**
     * @return string
     */
    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    /**
     * @param string $contactEmail
     */
    public function setContactEmail(string $contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return string
     */
    public function getContactCompanyDescription(): string
    {
        return $this->contactCompanyDescription;
    }

    /**
     * @param string $contactCompanyDescription
     */
    public function setContactCompanyDescription(string $contactCompanyDescription)
    {
        $this->contactCompanyDescription = $contactCompanyDescription;
    }

    /**
     * @return string
     */
    public function getContactFacebookLink(): string
    {
        return $this->contactFacebookLink;
    }

    /**
     * @param string $contactFacebookLink
     */
    public function setContactFacebookLink(string $contactFacebookLink)
    {
        $this->contactFacebookLink = $contactFacebookLink;
    }
}

