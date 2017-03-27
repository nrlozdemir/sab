<?php

namespace AddressBookBundle\Entity;

/**
 * GroupRelationships
 */
class GroupRelationships
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AddressBookBundle\Entity\Persons
     *
     * Bidirectional - Many persons have many groups (OWNING SIDE)
     *
     * @ManyToMany(targetEntity="Persons", inversedBy="setPerson")
     * @JoinTable(name="persons")
     */
    private $person;

    /**
     * @var \AddressBookBundle\Entity\Groups
     *
     * Bidirectional - Many groups have many persons (OWNING SIDE)
     *
     * @ManyToMany(targetEntity="Groups", inversedBy="setGroup")
     * @JoinTable(name="groups")
     */
    private $group;


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
     * @return GroupRelationships
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

    /**
     * Set group
     *
     * @param \AddressBookBundle\Entity\Groups $group
     *
     * @return GroupRelationships
     */
    public function setGroup(\AddressBookBundle\Entity\Groups $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AddressBookBundle\Entity\Groups
     */
    public function getGroup()
    {
        return $this->group;
    }
}

