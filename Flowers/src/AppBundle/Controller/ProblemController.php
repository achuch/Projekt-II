<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Problem;
use AppBundle\Form\ProblemType;

/**
 * Problem controller.
 *
 * @Route("/problem")
 */
class ProblemController extends Controller
{
    /**
     * Lists all Problem entities.
     *
     * @Route("/", name="problem_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $problems = $em->getRepository('AppBundle:Problem')->findAll();

        return $this->render('problem/index.html.twig', array(
            'problems' => $problems,
        ));
    }

    /**
     * Creates a new Problem entity.
     *
     * @Route("/new/{id}", name="problem_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, User $user)
    {
        $problem = new Problem();
        $form = $this->createForm('AppBundle\Form\ProblemType', $problem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $problem->setUser($user);
            $problem->setDateOfProblem(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($problem);
            $em->flush();

            return $this->render('problem/new.html.twig', array(
                'problem' => $problem,
                'form' => null,
                'message' => 'Dziekujemy za powiadomienie nas o problemie. Niezwlocznie powiadomimy o nim administatora.'
            ));
        }

        return $this->render('problem/new.html.twig', array(
            'problem' => $problem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Problem entity.
     *
     * @Route("/{id}", name="problem_show")
     * @Method("GET")
     */
    public function showAction(Problem $problem)
    {
        $deleteForm = $this->createDeleteForm($problem);

        return $this->render('problem/show.html.twig', array(
            'problem' => $problem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Problem entity.
     *
     * @Route("/{id}/edit", name="problem_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Problem $problem)
    {
        $deleteForm = $this->createDeleteForm($problem);
        $editForm = $this->createForm('AppBundle\Form\ProblemType', $problem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($problem);
            $em->flush();

            return $this->redirectToRoute('problem_edit', array('id' => $problem->getId()));
        }

        return $this->render('problem/edit.html.twig', array(
            'problem' => $problem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Problem entity.
     *
     * @Route("/{id}", name="problem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Problem $problem)
    {
        $form = $this->createDeleteForm($problem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($problem);
            $em->flush();
        }

        return $this->redirectToRoute('problem_index');
    }

    /**
     * Creates a form to delete a Problem entity.
     *
     * @param Problem $problem The Problem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Problem $problem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('problem_delete', array('id' => $problem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
