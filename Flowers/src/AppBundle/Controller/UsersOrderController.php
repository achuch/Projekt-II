<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\UsersOrder;
use AppBundle\Form\UsersOrderType;

/**
 * UsersOrder controller.
 *
 * @Route("/usersorder")
 */
class UsersOrderController extends Controller
{
    /**
     * Lists all UsersOrder entities.
     *
     * @Route("/", name="usersorder_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usersOrders = $em->getRepository('AppBundle:UsersOrder')->findBy(array('isFinished'=>true));

        return $this->render('usersorder/index.html.twig', array(
            'usersOrders' => $usersOrders,
        ));
    }

    /**
     * Creates a new UsersOrder entity.
     *
     * @Route("/new", name="usersorder_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usersOrder = new UsersOrder();
        $form = $this->createForm('AppBundle\Form\UsersOrderType', $usersOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usersOrder);
            $em->flush();

            return $this->redirectToRoute('usersorder_show', array('id' => $usersOrder->getId()));
        }

        return $this->render('usersorder/new.html.twig', array(
            'usersOrder' => $usersOrder,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UsersOrder entity.
     *
     * @Route("/{id}", name="usersorder_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, UsersOrder $usersOrder)
    {
        $deleteForm = $this->createDeleteForm($usersOrder);
        $editForm = $this->createForm('AppBundle\Form\UsersOrderType', $usersOrder);
        $editForm->handleRequest($request);
        $user = $usersOrder->getUser();
         $products = $usersOrder->getProducts();
        $address = $usersOrder->getAddress();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $usersOrder->setIsRealized(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usersOrder);
            $em->flush();

            return $this->render('usersorder/show.html.twig', array(
                'usersOrder' => $usersOrder,
                'delete_form' => $deleteForm->createView(),
                'edit_form' =>  null,
                'products' => $products,
                'user' => $user,
                'address' => $address
            ));
        }

        return $this->render('usersorder/show.html.twig', array(
            'usersOrder' => $usersOrder,
            'delete_form' => $deleteForm->createView(),
            'edit_form' => $editForm->createView(),
            'products' => $products,
            'user' => $user,
            'address' => $address
        ));
    }

    /**
     * Displays a form to edit an existing UsersOrder entity.
     *
     * @Route("/{id}/edit", name="usersorder_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository("AppBundle:UsersOrder")->findBy(array("user"=>$user->getId()));
        $countOrder = 0;
        foreach ($orders as $order) {
            if($order->getIsFinished() == false)
            {
                $usersOrder = $order;
            }
            $countOrder++;
        }

        if (isset($usersOrder) == false)
        {
            return $this->render('usersorder/edit.html.twig', array(
                'usersOrder' => null,
                'products' => null,
                'edit_form' => null,
                'delete_form' => null,
                'user' => null,
                'sum' => null,
                'message' => 'Dodaj cos do zamowienia :)'
            ));
        }

        $products = $usersOrder->getProducts();
        $sum = 0;
        foreach ( $products as $item) {
                $sum += $item->getPrice();
        }
        $message = "";
        //if ($countOrder % 10 == 0)
        if ($countOrder == 9) {
            $sum = $sum * 0.9;
            $message = "Brawo ! Dostaje rabat 10 % !";
        }

        $deleteForm = $this->createDeleteForm($usersOrder);
        $editForm = $this->createForm('AppBundle\Form\UsersOrderType', $usersOrder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $usersOrder->setIsFinished(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usersOrder);
            $em->flush();

//            return $this->render('usersorder/edit.html.twig', array(
//                'usersOrder' => $usersOrder,
//                'products' => $products,
//                'edit_form' => $editForm->createView(),
//                'delete_form' => $deleteForm->createView(),
//                'user' => $user,
//                'sum' => $sum,
//                'message' => 'Dziękuje za złożenie zamówienia. Zostanie ono dostarczone jak najszybiej :)'
//            ));

            return $this->redirect($this->generateUrl("address_new", array('id'=>$usersOrder->getId())));
        }

        return $this->render('usersorder/edit.html.twig', array(
            'usersOrder' => $usersOrder,
            'products' => $products,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user,
            'sum' => $sum,
            'message' => $message
        ));
    }

    /**
     * Deletes a UsersOrder entity.
     *
     * @Route("/{id}", name="usersorder_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UsersOrder $usersOrder)
    {
        $form = $this->createDeleteForm($usersOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usersOrder);
            $em->flush();
        }

        return $this->redirectToRoute('usersorder_index');
    }

    /**
     * Creates a form to delete a UsersOrder entity.
     *
     * @param UsersOrder $usersOrder The UsersOrder entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UsersOrder $usersOrder)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usersorder_delete', array('id' => $usersOrder->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
