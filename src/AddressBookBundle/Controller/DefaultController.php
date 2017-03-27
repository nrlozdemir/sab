<?php

namespace AddressBookBundle\Controller;

use AddressBookBundle\AddressBookBundle;
use AddressBookBundle\Entity\Groups;
use AddressBookBundle\Entity\GroupRelationships;
use AddressBookBundle\Entity\Persons;
use AddressBookBundle\Entity\EmailAddresses;
use AddressBookBundle\Entity\Streets;
use AddressBookBundle\Entity\PhoneNumbers;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\DoctrineAdapter;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Tests\Fixtures\Controller\NullableController;
use Symfony\Component\Validator\Constraints\Email;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="address_book_homepage")
     *
     * @return display template
     */
    public function indexAction()
    {
        return $this->render('AddressBookBundle:Default:index.html.twig');
    }

    /**
     * @Route("/add_group", name="address_book_addGroup")
     *
     * @param Request $request
     *
     * @return display template
     */
    public function addGroupAction(Request $request)
    {
        /* Create Doctrine Entity Manager */
        $em = $this->getDoctrine()->getManager();

        $inserted = FALSE;

        if($request->getMethod() === 'POST'
            AND $request->request->has('name'))
        {
            /* Set variables to entity manager + Insert to Database */
            try
            {
                $name = $request->request->get('name');

                $groups = new Groups();
                $groups->setName($name);

                $em->persist($groups);
                $em->flush();
                $inserted = TRUE;
            }
            catch(\Doctrine\ORM\ORMException $e)
            {
                /* $this->get('logger')->error($e->getMessage()); */
            }
        }

        return $this->render('AddressBookBundle:Default:AddGroup.html.twig', array(
            'inserted' => $inserted,
        ));
    }

    /**
     * @Route("/group_list", name="address_book_groupList")
     *
     * @return display template
     */
    public function groupListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('AddressBookBundle:Groups')->findAll();

        return $this->render('AddressBookBundle:Default:GroupList.html.twig', array(
            'groups' => $groups,
        ));
    }

    /**
     * @Route("/group_details/{groupId}", name="address_book_groupDetails", requirements={"groupId": "\d+"})
     *
     * @param Request $request
     * @param Integer $groupId
     *
     * @return display template
     */
    public function groupDetailsAction(Request $request = null, $groupId)
    {
        $em = $this->getDoctrine()->getManager();

        $groupsObject = new Groups();
        $persons = $groupsObject->getDetails($groupId, $em);

        return $this->render('AddressBookBundle:Default:GroupDetails.html.twig', array(
            'persons' => $persons,
        ));
    }

    /**
     * @Route("/add_person", name="address_book_addPerson")
     *
     * @param Request $request
     *
     * @return display template
     */
    public function addPersonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('AddressBookBundle:Groups')->findAll();

        $inserted = FALSE;

        /*
         * First Action     : Person will be added according to incoming post data.
         * Second Action    : Each email address(es) will be added and assigned to the inserted person
         * Third Action     : Each street(s) will be added and assigned to the inserted person
         * 4th Action       : Each telephone number(s) will be added and assigned to the inserted person
         * 5th Action       : Incoming group id(s) will be inserted with person id to relationship table.
         */
        if($request->getMethod() === 'POST'
            AND $request->request->has('first_name')
            AND $request->request->has('last_name'))
        {
            try
            {
                /* First Action */
                $firstName = $request->request->get('first_name');
                $lastName = $request->request->get('last_name');

                $newPerson = new Persons();
                $newPerson->setFirstName($firstName);
                $newPerson->setLastName($lastName);

                $em->persist($newPerson);
                $em->flush();
                $inserted = TRUE;

                /* Set inserted id parameter to a variable for using in other actions */
                $insertedPersonId = $newPerson->getId();

                /* Second Action */
                if($request->request->has('emails') AND isset($insertedPersonId))
                {
                    foreach($request->request->get('emails') as $key => $value)
                    {
                        try
                        {
                            $newEmailAddress = new EmailAddresses();
                            $newEmailAddress->setEmailAddress($value);
                            $newEmailAddress->setPerson($newPerson);
                            $em->persist($newEmailAddress);
                            $em->flush();
                        }
                        catch(\Doctrine\ORM\ORMException $e)
                        {
                            /* $this->get('logger')->error($e->getMessage()); */
                        }
                    }

                    unset($key, $value);
                }

                /* Third Action */
                if($request->request->has('streets') AND isset($insertedPersonId))
                {
                    foreach($request->request->get('streets') as $key => $value)
                    {
                        try
                        {
                            $newStreet = new Streets();
                            $newStreet->setStreet($value);
                            $newStreet->setPerson($newPerson);
                            $em->persist($newStreet);
                            $em->flush();
                        }
                        catch(\Doctrine\ORM\ORMException $e)
                        {
                            /* $this->get('logger')->error($e->getMessage()); */
                        }
                    }

                    unset($key, $value);
                }

                /* 4th Action */
                if($request->request->has('phone_numbers') AND isset($insertedPersonId))
                {
                    foreach($request->request->get('phone_numbers') as $key => $value)
                    {
                        try
                        {
                            $newPhoneNumber = new PhoneNumbers();
                            $newPhoneNumber->setPhoneNumber($value);
                            $newPhoneNumber->setPerson($newPerson);
                            $em->persist($newPhoneNumber);
                            $em->flush();
                        }
                        catch(\Doctrine\ORM\ORMException $e)
                        {
                            /* $this->get('logger')->error($e->getMessage()); */
                        }

                        unset($key, $value);
                    }
                }

                /* 5th Action */
                if($request->request->has('groups') AND isset($insertedPersonId))
                {
                    foreach($request->request->get('groups') as $key => $value)
                    {
                        try
                        {
                            $group = $em->getReference('AddressBookBundle\Entity\Groups', $value);
                            /* $group = $em->getRepository('AddressBookBundle:Groups')->findOneById((int)$value); */

                            $newRelationship = new GroupRelationships();

                            $newRelationship->setGroup($group);
                            $newRelationship->setPerson($newPerson);
                            $em->persist($newRelationship);
                            $em->flush();
                        }
                        catch(\Doctrine\ORM\ORMException $e)
                        {
                            /* $this->get('logger')->error($e->getMessage()); */
                        }

                        unset($key, $value);
                    }
                }
            }
            catch(\Doctrine\ORM\ORMException $e)
            {
                $this->get('logger')->error($e->getMessage());
            }
        }

        return $this->render('AddressBookBundle:Default:AddPerson.html.twig', array(
            'inserted' => $inserted,
            'groups' => $groups
        ));
    }

    /**
     * Route("/person_list", name="address_book_personList")
     *
     * @param Request $request
     * @param integer $personId
     *
     * @return display template
     */
    public function personListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $postFindByName = null;
        $postFindByEmail = null;
        $persons = array();

        if($request->getMethod() === 'POST')
        {
            if($request->request->has('find_by_name')
                AND strlen(str_replace(' ', '', $request->request->get('find_by_name'))) != 0)
            {
                $postFindByName = $_POST['find_by_name'];
                $findByName = $request->request->get('find_by_name');

                $personObject = new Persons();
                $persons = $personObject->getListFindByName($findByName, $em);
            }

            elseif($request->request->has('find_by_email')
                AND strlen(str_replace(' ', '', $request->request->get('find_by_email'))) != 0)
            {
                $postFindByEmail = $_POST['find_by_email'];
                $findByEmail = $request->request->get('find_by_email');

                $personObject = new Persons();
                $persons = $personObject->getListFindByEmail($findByEmail, $em);
            }
        }
        else
        {
            $persons = $em->getRepository('AddressBookBundle:Persons')->findAll();
        }

        return $this->render('AddressBookBundle:Default:PersonList.html.twig', array(
            'persons' => $persons,
            'findByNameValue' => $postFindByName,
            'findByEmailValue' => $postFindByEmail,
        ));
    }

    /**
     * @Route("/person_details/{personId}", name="address_book_personDetails", requirements={"personId": "\d+"})
     *
     * @param Request $request
     * @param integer $personId
     *
     * @return display template
     */
    public function personDetailsAction(Request $request = null, $personId)
    {
        $em = $this->getDoctrine()->getManager();

        $groupsObject = new Groups();
        $groups = $groupsObject->getGroupsByPerson($personId, $em);

        return $this->render('AddressBookBundle:Default:PersonDetails.html.twig', array(
            'groups' => $groups,
        ));
    }
}