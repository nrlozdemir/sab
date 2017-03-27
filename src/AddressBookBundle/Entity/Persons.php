<?php

namespace AddressBookBundle\Entity;


/**
 * Persons
 */
class Persons
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Persons
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Persons
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
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
     * Get List Find By Name
     *
     * @param string $name
     * @param object $em
     *
     * @return $result
     */
    public function getListFindByName($name, &$em)
    {
        $result = $em->createQueryBuilder()
            ->from("AddressBookBundle\Entity\Persons", 'p')
            ->select("p.id, p.firstName, p.lastName, CONCAT( p.firstName, ' ', p.lastName ) AS fullName")
            ->where('p.firstName LIKE :searchTag1')
            ->setParameter('searchTag1', "$name")
            ->orWhere('p.lastName LIKE :searchTag2')
            ->setParameter('searchTag2', "$name")
            ->orWhere('CONCAT( p.firstName, \' \', p.lastName ) LIKE :searchTag3')
            ->setParameter('searchTag3', "$name")
            ->getQuery()
            ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

        return $result;
    }

    /**
     * Get List Find By Email
     *
     * @param string $email
     * @param object $em
     *
     * @return $result
     */
    public function getListFindByEmail($email, &$em)
    {
        $result = $em->createQueryBuilder()
            ->from("AddressBookBundle\Entity\EmailAddresses", 'em')
            ->select("p.id, p.firstName, p.lastName")
            ->innerJoin("AddressBookBundle\Entity\Persons", "p", "WITH", "em.person = p.id")
            ->where('em.emailAddress LIKE :searchTag1')
            ->setParameter('searchTag1', "$email")
            ->where('em.emailAddress LIKE :searchTag1')
            ->setParameter('searchTag1', "$email%")
            ->getQuery()
            ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

        return $result;
    }
}

