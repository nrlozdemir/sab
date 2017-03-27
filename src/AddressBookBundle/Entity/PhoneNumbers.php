<?php

namespace AddressBookBundle\Entity;

/**
 * PhoneNumbers
 */
class PhoneNumbers
{
    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AddressBookBundle\Entity\Persons
     */
    private $person;


    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return PhoneNumbers
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

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
     * Set person
     *
     * @param \AddressBookBundle\Entity\Persons $person
     *
     * @return PhoneNumbers
     */
    public function setPerson(\AddressBookBundle\Entity\Persons $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \AddressBookBundle\Entity\Persons
     */
    public function getPerson()
    {
        return $this->person;
    }
}

