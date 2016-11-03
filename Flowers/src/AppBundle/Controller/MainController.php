<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
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

        $this->whoIsLogIn = new User();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $repo = $this->getDoctrine()->getRepository('AppBundle:User');
            $users = $repo->findOneBy(array("emailAddress"=>"aaa@aaa.com"));
            echo $users->getEmailAddress();

            $validatePassword = $this->get('security.encoder_factory')->getEncoder($user)->isPasswordValid($users->getPassword(),$user->getPassword(),$user->getSalt());

            if ($validatePassword)
            {
                $this->whoIsLogIn = $users;

                $request->getSession()->set('whoisLogIn',"ktos");

                if($users->getType() == "0")
                    return $this->redirect($this->generateUrl("adminProfile"));
            }
        }

        return $this->render('AppBundle:Main:index.html.twig', array(
            'form' => $form->createView()

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
        if ($request->getSession()->get('whoisLogIn') == "ktos")
        {
            $request->getSession()->set('whoislogin','none');
            return $this->render('AppBundle:Main:adminProfile.html.twig');
        }
        else
            return $this->redirect($this->generateUrl("index"));


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
