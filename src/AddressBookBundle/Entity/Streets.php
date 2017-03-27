<?php

namespace AddressBookBundle\Entity;

/**
 * Streets
 */
class Streets
{
    /**
     * @var string
     */
    private $street;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AddressBookBundle\Entity\Persons
     */
    private $person;


    /**
     * Set street
     *
     * @param string $street
     *
     * @return Streets
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
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
     * @return Streets
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

