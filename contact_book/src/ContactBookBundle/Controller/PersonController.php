<?php

namespace ContactBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBookBundle\Entity\Person;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PersonController extends Controller {

    public function formCreate($inputArray, $person = null) {
        if($person == null){
            $person = new Person();
        }
        $form = $this->createFormBuilder($person);

        foreach ($inputArray as $key => $value) {
            $form->add($key, $value);
        }
        return $form->getForm();
    }

    /**
     * @Route("/new")
     * @Method("GET")
     */
    public function showNewFormAction() {

        return $this->render('ContactBookBundle:Person:show_new_form.html.twig', array(
            'form' => $this->formCreate(['name' => 'text', 'last_name' => 'text', 'description' => 'text', 'Add' => 'submit'])->createView()
        ));
    }

    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function createNewAction(Request $request) {

        $form = $this->formCreate(['name' => 'text', 'last_name' => 'text', 'description' => 'text', 'Add' => 'submit']);
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
    public function showEditFormAction() {
        
        return $this->render('ContactBookBundle:Person:show_edit_form.html.twig', array(
            'form' => $this->formCreate(['name' => 'text', 'last_name' => 'text', 'description' => 'text', 'Edit' => 'submit'])->createView()
        ));
    }

    /**
     * @Route("/{id}/modify")
     * @Method("POST")
     */
    public function editAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository('ContactBookBundle:Person');
        $person = $repository->find($id);
        $form = $this->formCreate(['name' => 'text', 'last_name' => 'text', 'description' => 'text', 'Edit' => 'submit'], $person);
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
     * @Route("/{id}/delete")
     */
    public function deleteAction($id) {
        $repository = $this->getDoctrine()->getRepository('ContactBookBundle:Person');
        $person = $repository->find($id);
        if($person){
            $em = $this->getDoctrine()->getManager();
            $em->remove($person);
            $em->flush();

            return $this->render('ContactBookBundle:Person:delete.html.twig');
        }else{
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
