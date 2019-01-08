<?php

namespace SC\CommonBundle\Controller;

use SC\CommonBundle\Entity\Student;
use SC\CommonBundle\Entity\Group;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SC\CommonBundle\Form\StudentType;
use SC\CommonBundle\Form\StudentEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Student controller.
 *
 * @Route("/student")
 */

class StudentController extends Controller
{

  /**
   * @Route("/", name="student_list")
   */
  public function indexAction(Request $request)
  {

    $listStudent = $this->getDoctrine()->getManager()->getRepository("SCCommonBundle:Student")->findAll();

    // return student list
    return $this->render('SCCommonBundle:Panel:index.html.twig', array(
      'listStudent' => $listStudent
    ));
  }

   /**
     * @Route("/student/{id}", name="student_view")
     */

  public function viewAction($id)
  {
    // getting repo
    $em = $this->getDoctrine()->getManager();

    $student = $em->getRepository('SCCommonBundle:Student')->find($id);
    
    if (null === $student) {
      throw new NotFoundHttpException("Student with ".$id." does not exist.");
    }
   
    return $this->render('SCCommonBundle:Panel:view.html.twig', array(
      'student' => $student
    ));
  }

  /**
     * @Route("/add", name="student_add")
     */
  public function addAction(Request $request)
  {
    $student = new Student();

    $form = $this->createForm(studentType::class, $student);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($student);
      $em->flush();


      return $this->redirectToRoute('student_view', array('id' => $student->getId()));     
    }
    
    return $this->render('SCCommonBundle:Panel:add.html.twig', array('form' => $form->createView(), 
    ));
  }

   /**
     * @Route("/edit/{id}", name="student_edit")
     */
  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $student = $em->getRepository('SCCommonBundle:Student')->find($id);

    if (null === $student) {
      throw new NotFoundHttpException("Student with ".$id." does not exist.");
    }

    $form = $this->createForm(studentEditType::class, $student);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){

        $em->flush();

        $request->getSession()->getFlashBag()->add('message', 'Student has been modified');
        
        return $this->redirectToRoute('student_view', array('id' => $student->getId()));
    }

    return $this->render('SCCommonBundle:Panel:edit.html.twig', array(
      'student' => $student,
      'form' => $form->createView()
    ));
  }

  /**
     * @Route("/delete/{id}", name="student_delete")
     */

  public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $student = $em->getRepository('SCCommonBundle:Student')->find($id);

    if (null === $student) {
      throw new NotFoundHttpException("student with ".$id." does not exist.");
    }

    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($student);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "Student has been deleted");

      return $this->redirectToRoute('student_list');

    }

   return $this->render('SCCommonBundle:Panel:delete.html.twig', array('student' => $student, 'form' => $form->createView()));

  }

  /**
   * @Rest\View()
   * @Rest\Get("/students-api")
   */

  public function getStudentsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $students = $em->getRepository('SCCommonBundle:Student')->findAll();

        $formatted = [];
        foreach ($students as $student) {
            $formatted[] = ['id' => $student->getId(), 'firstName' => $student->getFirstName(), 'lastname' => $student->getLastName(), 'numEtud' => $student->getNumEtud(), 'departement' => $student->getDepartment()->getName()];
        }

        $viewHandler = $this->get('fos_rest.view_handler');

        $view = View::create($formatted);
        $view->setFormat('json');

        return $viewHandler->handle($view);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/students-api/{department_name}")
     */
    public function getstudentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $students = $em->getRepository('SCCommonBundle:Student')->getStudentsByDepartment($request->get('department_name'));

        $counter = 0;
        $arrData = array();

        if (empty($students)) {
            return new JsonResponse(['message' => 'student not found'], Response::HTTP_NOT_FOUND);
        }

        foreach ($students as $student) {

          $formatted = ['id' => $student->getId(), 'firstName' => $student->getFirstName(), 'lastname' => $student->getLastName(), 'numEtud' => $student->getNumEtud(), 'departement' => $student->getDepartment()->getName()];
          $arrData[$counter] = $formatted;
          $counter++;
        }

        $viewHandler = $this->get('fos_rest.view_handler');

        $view = View::create($arrData);
        $view->setFormat('json');

        return $viewHandler->handle($view);
    }



}
