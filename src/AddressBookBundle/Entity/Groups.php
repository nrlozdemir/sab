<?php

namespace AddressBookBundle\Entity;

/**
 * Groups
 */
class Groups
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Groups
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Get List By Person
     * -> Find all groups by given person
     * @param integer $person
     * @param object $em
     *
     * @return $result
     */
    public function getGroupsByPerson($person, &$em)
    {
        $result = $em->createQueryBuilder()
            ->from("AddressBookBundle\Entity\GroupRelationships", 'gr')
            ->select("g.id, g.name")
            ->leftJoin("AddressBookBundle\Entity\Persons", "p", "WITH", "gr.person = p.id")
            ->leftJoin("AddressBookBundle\Entity\Groups", "g", "WITH", "gr.group = g.id")
            ->where("gr.person = :relationshipPersonId")
            ->setParameter('relationshipPersonId', $person)
            ->getQuery()
            ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

        return $result;
    }

    /**
     * Get Details
     * -> Find all persons in a group
     * @param integer $groupId
     * @param object $em
     *
     * @return $result
     */
    public function getDetails($id, &$em)
    {
        $result = $em->createQueryBuilder()
            ->from("AddressBookBundle\Entity\GroupRelationships", 'gr')
            ->select("p.id, p.firstName, p.lastName")
            ->leftJoin("AddressBookBundle\Entity\Persons", "p", "WITH", "gr.person = p.id")
            ->leftJoin("AddressBookBundle\Entity\Groups", "g", "WITH", "gr.group = g.id")
            ->where("gr.group = :relationshipGroupId")
            ->setParameter('relationshipGroupId', $id)
            ->getQuery()
            ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

        return $result;
    }
}

