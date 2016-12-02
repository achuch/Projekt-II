<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use AppBundle\Entity\UsersOrder;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\OrderProducts;
use AppBundle\Form\OrderProductsType;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Date;

/**
 * OrderProducts controller.
 *
 * @Route("/orderproducts")
 */
class OrderProductsController extends Controller
{
    /**
     * Lists all OrderProducts entities.
     *
     * @Route("/", name="orderproducts_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orderProducts = $em->getRepository('AppBundle:OrderProducts')->findAll();

        return $this->render('orderproducts/index.html.twig', array(
            'orderProducts' => $orderProducts,
        ));
    }

    /**
     * Creates a new OrderProducts entity.
     *
     * @Route("/new/{id}/{user}", name="orderproducts_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Product $product, User $user)
    {
        $orderProduct = new OrderProducts();
        $form = $this->createForm('AppBundle\Form\OrderProductsType', $orderProduct);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('AppBundle:UsersOrder')->findBy(array('user'=>$user->getId()));

        if ($form->isSubmitted() && $form->isValid()) {

            if ($product->getAmountOfStock() < $orderProduct->getAmount())
            {
                return $this->render('orderproducts/new.html.twig', array(
                    'orderProduct' => $orderProduct,
                    'form' => $form->createView(),
                    'product' => $product,
                    'orders' => $orders,
                    'message' => 'Bład !!! Za duża ilosc !!!'
                ));
            }
            $price = $product->getPrice() * $orderProduct->getAmount();
            $orderProduct->setPrice($price);
            $orderProduct->setProduct($product);
            $amount = $product->getAmountOfStock() - $orderProduct->getAmount();
            $product->setAmountOfStock($amount);
            $em->persist($product);
            $em->flush();


            if ($orders == null)
            {
                $order = new UsersOrder();
                $order->setDate(new \DateTime());
                $order->setUser($user);
                $order->setIsFinished(false);
                $order->setIsRealized(false);
                $em->persist($order);
                $em->flush();
                $order_id = $em->getRepository('AppBundle:UsersOrder')->findOneBy(array('user'=>$user->getId()));
                $orderProduct->setOrder($order_id);

            }
            else{
                $listOfOrder = new ArrayCollection();
                foreach ($orders as $order) {
                    if($order->getIsFinished()==false) {
                        $listOfOrder->add($order);
                    }
                }
                if($listOfOrder->get(0) == null)
                {
                    $order = new UsersOrder();
                    $order->setDate(new \DateTime());
                    $order->setUser($user);
                    $order->setIsFinished(false);
                    $order->setIsRealized(false);
                    $em->persist($order);
                    $em->flush();
                    $order_id = $em->getRepository('AppBundle:UsersOrder')->findOneBy(array('isFinished'=>false));
                    $orderProduct->setOrder($order_id);
                }
                else
                {
                    $order = $listOfOrder->get(0);
                    $orderProduct->setOrder($order);
                }

            }

            $em->persist($orderProduct);
            $em->flush();

            return $this->render('orderproducts/new.html.twig', array(
                'orderProduct' => $orderProduct,
                'form' => null,
                'product' => $product,
                'orders' => $orders,
                'message' => 'Dodano do zamowienia !'
            ));
        }

        return $this->render('orderproducts/new.html.twig', array(
            'orderProduct' => $orderProduct,
            'form' => $form->createView(),
            'product' => $product,
            'orders' => $orders,
            'message' => ''
        ));
    }

    /**
     * Finds and displays a OrderProducts entity.
     *
     * @Route("/{id}", name="orderproducts_show")
     * @Method("GET")
     */
    public function showAction(OrderProducts $orderProduct)
    {
        $deleteForm = $this->createDeleteForm($orderProduct);

        return $this->render('orderproducts/show.html.twig', array(
            'orderProduct' => $orderProduct,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrderProducts entity.
     *
     * @Route("/{id}/edit/{user}", name="orderproducts_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OrderProducts $orderProduct, User $user)
    {
        $deleteForm = $this->createDeleteForm($orderProduct);
        $editForm = $this->createForm('AppBundle\Form\OrderProductsType', $orderProduct);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $orderProduct->setPrice($orderProduct->getProduct()->getPrice() * $orderProduct->getAmount());
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderProduct);
            $em->flush();

            return $this->redirectToRoute('orderproducts_edit', array('id' => $orderProduct->getId(), 'user' => $user->getId()));
        }

        return $this->render('orderproducts/edit.html.twig', array(
            'orderProduct' => $orderProduct,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user
        ));
    }

    /**
     * Deletes a OrderProducts entity.
     *
     * @Route("/{id}", name="orderproducts_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OrderProducts $orderProduct)
    {
        $form = $this->createDeleteForm($orderProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orderProduct);
            $em->flush();
        }

        return $this->redirectToRoute('orderproducts_index');
    }

    /**
     * Creates a form to delete a OrderProducts entity.
     *
     * @param OrderProducts $orderProduct The OrderProducts entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrderProducts $orderProduct)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orderproducts_delete', array('id' => $orderProduct->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
