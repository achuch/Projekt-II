<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Seller;
use AppBundle\Form\SellerType;

/**
 * Seller controller.
 *
 * @Route("/seller")
 */
class SellerController extends Controller
{
    /**
     * Lists all Seller entities.
     *
     * @Route("/", name="seller_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sellers = $em->getRepository('AppBundle:Seller')->findAll();

        return $this->render('seller/index.html.twig', array(
            'sellers' => $sellers,
        ));
    }

    /**
     * Creates a new Seller entity.
     *
     * @Route("/new", name="seller_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $seller = new Seller();
        $form = $this->createForm('AppBundle\Form\SellerType', $seller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($seller, $seller->getPassword());
            $seller->setPassword($password);


            $em = $this->getDoctrine()->getManager();
            $em->persist($seller);
            $em->flush();

            return $this->redirectToRoute('seller_show', array('id' => $seller->getId()));
        }

        return $this->render('seller/new.html.twig', array(
            'seller' => $seller,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Seller entity.
     *
     * @Route("/{id}", name="seller_show")
     * @Method("GET")
     */
    public function showAction(Seller $seller)
    {
        $deleteForm = $this->createDeleteForm($seller);

        return $this->render('seller/show.html.twig', array(
            'seller' => $seller,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Seller entity.
     *
     * @Route("/{id}/edit", name="seller_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Seller $seller)
    {
        $deleteForm = $this->createDeleteForm($seller);
        $editForm = $this->createForm('AppBundle\Form\SellerType', $seller);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($seller);
            $em->flush();

            return $this->redirectToRoute('seller_edit', array('id' => $seller->getId()));
        }

        return $this->render('seller/edit.html.twig', array(
            'seller' => $seller,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Seller entity.
     *
     * @Route("/{id}", name="seller_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Seller $seller)
    {
        $form = $this->createDeleteForm($seller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($seller);
            $em->flush();
        }

        return $this->redirectToRoute('seller_index');
    }

    /**
     * Creates a form to delete a Seller entity.
     *
     * @param Seller $seller The Seller entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Seller $seller)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seller_delete', array('id' => $seller->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
