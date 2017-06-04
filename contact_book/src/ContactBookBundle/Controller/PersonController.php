<?php

namespace ContactBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBookBundle\Entity\Person;
use ContactBookBundle\Entity\Address;
use ContactBookBundle\Entity\Phone;
use ContactBookBundle\Entity\Email;
use ContactBookBundle\Entity\Type;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PersonController extends Controller {
    
    public function createFormEntity($entity, $id=null){
        if ($id == null) {
            $entity =  "ContactBookBundle\Entity\\$entity";
            $formEntity = new $entity;
        } else {
            $repository = $this->getDoctrine()->getRepository('ContactBookBundle:'.$entity);
            $formEntity = $repository->find($id);
        }
        return $formEntity;
    }

    public function formCreate($inputArray, $entity, $id = null, $action = "", $entityOptions=null) {

        $entity = $this->createFormEntity($entity, $id);
        $form = $this->createFormBuilder($entity);
        $form->setAction($action);

        foreach ($inputArray as $key => $value) {
            if($value == 'entity'){
                $form->add($key, $value, $entityOptions);
            }else{
                $form->add($key, $value);      
            }
        }
        return $form->getForm();
    }

    /**
     * @Route("/new")
     * @Method("GET")
     */
    public function showNewFormAction() {

        return $this->render('ContactBookBundle:Person:show_new_form.html.twig', array(
                    'form' => $this->formCreate(['name' => 'text', 'last_name' => 'text', 'description' => 'text', 'Add' => 'submit'], 'Person')->createView()
        ));
    }

    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function createNewAction(Request $request) {

        $form = $this->formCreate(['name' => 'text', 'last_name' => 'text', 'description' => 'text', 'Add' => 'submit'], 'Person');
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
        }
        return $this->render('ContactBookBundle:Person:create_new.html.twig', array(
                        // ...
        ));
    }

    /**
     * @Route("/{id}/modify")
     * @Method("GET")
     */
    public function showEditFormAction($id) {

        $repository = $this->getDoctrine()->getRepository('ContactBookBundle:Person');
        $person = $repository->find($id);
        return $this->render('ContactBookBundle:Person:show_edit_form.html.twig', array(
                    'form' => $this->formCreate(['name' => 'text', 
                                                 'last_name' => 'text', 
                                                 'description' => 'text', 
                                                 'Edit' => 'submit'], 'Person', $id)->createView(),
                    'form2' =>$this->formCreate(['city' => 'text', 
                                                 'street' => 'text', 
                                                 'street_number' => 'integer', 
                                                 'apartment_number' => 'integer', 
                                                 'Edit' => 'submit'], 'Address', null, "/".$person->getId()."/addAddress")->createView(),
                    'form3' =>$this->formCreate(['number' => 'integer',
                                                 'type' => 'entity'], 
                                                'Phone', null, "/".$person->getId()."addPhone", 
                                                array('class'=>'ContactBookBundle:Type',
                                                      'choice_label' => 'type'))
                                                ->createView(),
                    'form4' =>$this->formCreate(['email' => 'text',
                                                 'type' => 'entity'], 
                                                'Email', null, "/".$person->getId()."addEmail", 
                                                array('class'=>'ContactBookBundle:Type',
                                                      'choice_label' => 'type'))
                                                ->createView(),
        ));
    }

    /**
     * @Route("/{id}/modify")
     * @Method("POST")
     */
    public function editInfoAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository('ContactBookBundle:Person');
        $person = $repository->find($id);
        $form = $this->formCreate(['name' => 'text', 'last_name' => 'text', 'description' => 'text', 'Edit' => 'submit'], 'Person', $id);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            return $this->render('ContactBookBundle:Person:edit.html.twig');
        }
        throw new Exception('Nie udało się edytować kontaktu');
    }
        /**
     * @Route("/{id}/addAddress")
     * @Method("POST")
     */
    public function editAddressAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository('ContactBookBundle:Person');
        $person = $repository->find($id);
        $form = $this->formCreate(['city' => 'text', 
                                   'street' => 'text', 
                                   'street_number' => 'integer', 
                                   'apartment_number' => 'integer', 
                                   'Edit' => 'submit'], 'Address', null, "/".$person->getId()."/addAddress");
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $address = $form->getData();
            $person->setAddress($address);
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->render('ContactBookBundle:Person:edit.html.twig');
        }
        throw new Exception('Nie udało się edytować kontaktu');
    }

    /**
     * @Route("/{id}/delete")
     */
    public function deleteAction($id) {
        $repository = $this->getDoctrine()->getRepository('ContactBookBundle:Person');
        $person = $repository->find($id);
        if ($person) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($person);
            $em->flush();

            return $this->render('ContactBookBundle:Person:delete.html.twig');
        } else {
            throw new Exception('Nie udało się usunąć użytkownika');
        }
    }

    /**
     * @Route("/{id}")
     */
    public function showOneAction($id) {
        $repository = $this->getDoctrine()->getRepository('ContactBookBundle:Person');
        $person = $repository->find($id);
        return $this->render('ContactBookBundle:Person:show_one.html.twig', array(
                    'person' => $person
        ));
    }

    /**
     * @Route("/")
     */
    public function showAllAction() {
        $repository = $this->getDoctrine()->getRepository('ContactBookBundle:Person');
        $contacts = $repository->findAll();
        return $this->render('ContactBookBundle:Person:show_all.html.twig', array(
                    'contacts' => $contacts
        ));
    }

}
