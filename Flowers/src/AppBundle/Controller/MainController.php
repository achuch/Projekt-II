<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\UsersOrder;
use AppBundle\Form\LoginType;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    private $whoIsLogIn = null;
    /**
     * @Route("/index", name="index")
     */
    public function indexAction(Request $request)
    {

        $user = new User();
        $form = $this->createForm(LoginType::class, $user);

        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $repo = $this->getDoctrine()->getRepository('AppBundle:User');

            $users = $repo->findOneBy(array("emailAddress"=> $user->getEmailAddress()));

            $validatePassword = $this->get('security.encoder_factory')->getEncoder($user)->isPasswordValid($users->getPassword(),$user->getPassword(),$user->getSalt());

            if ($validatePassword)
            {
                if($users->getType() == "0") {
                    $request->getSession()->set('whoisLogIn', "admin");
                    return $this->redirect($this->generateUrl("adminProfile"));
                }
                else {
                    $request->getSession()->set('whoisLogIn', "users");

                    //$orders = $em->getRepository('AppBundle:UsersOrder')->findBy(['user'=>$user]);
                    $repoOrders = $this->getDoctrine()->getRepository('AppBundle:UsersOrder');
                    $orders = $repoOrders->findBy(array('user'=>$users->getId()));
                    $isMainOrder = false;

                    foreach ($orders as $order) {
                        if ($order->getIsFinished() == false)
                        {
                            $isMainOrder = true;
                        }
                    }
                    return $this->render('AppBundle:Main:index.html.twig', array(
                        'form' => null,
                        'user' => $users,
                        'orders' => $orders,
                        'products' => $products,
                        'order' => $isMainOrder,

                    ));
                }
            }
        }

        return $this->render('AppBundle:Main:index.html.twig', array(
            'form' => $form->createView(),
            'products' => $products

        ));
    }

    /**
     * @Route("/adminProfile", name="adminProfile")
     */
    public function adminProfileAction(Request $request)
    {
        //if($this->whoIsLogIn != null)
        //{
           // if($this->whoIsLogIn->getType() != "0") {
           //     echo "Admin Profile";

            //}
        if ($request->getSession()->get('whoisLogIn') == "admin")
        {
            $request->getSession()->set('whoislogin','none');
            return $this->render('AppBundle:Main:adminProfile.html.twig');
        }
        else
            return $this->redirect($this->generateUrl("index"));


    }

    /**
     * @Route("/showRepo", name="showRepo")
     */
    public function showRepoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();

        $x = 0;

        foreach ($products as $item) {
            $x += ($item->getPrice() * $item->getAmountOfStock());
        }

        return $this->render('product/indexRepo.html.twig', array(
            'products' => $products,
            'sum' => $x,
        ));
    }


    /**
     * @Route("/logout", name="logOut")
     */
    public function logOutAction(Request $request)
    {
        $request->getSession()->clear();
        return $this->redirect($this->generateUrl("index"));
    }

}
