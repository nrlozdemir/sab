<?php

namespace AddressBookBundle\Entity;

/**
 * EmailAddresses
 */
class EmailAddresses
{
    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AddressBookBundle\Entity\Persons
     */
    private $person;


    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return EmailAddresses
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
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
     * @return EmailAddresses
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

