<?php

namespace Knib\TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Knib\TodoBundle\Entity\Task;
use Knib\TodoBundle\Entity\User;
use Knib\TodoBundle\Form\UserType;

class TaskController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
                ->getRepository('KnibTodoBundle:Task');
        $tasks = $repository->findAll();
        
        return $this->render('KnibTodoBundle:Default:task.html.twig', array('tasks' => $tasks));
    }
    
    public function newAction(Request $request){
        $task = new Task();
        $form = $this->createFormBuilder($task)
            ->add('name', 'text')
            ->add('save', 'submit')
            ->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

                return $this->redirect($this->generateUrl('knib_todo_homepage'));
            }
        }
        
         return $this->render('KnibTodoBundle:Default:new.html.twig', array('form' => $form->createView(),));
    }
    
    public function showAction($id)
    {
        $repository = $this->getDoctrine()
                ->getRepository('KnibTodoBundle:Task');
        $task = $repository->find($id);
        if (!$task) {
            throw $this->createNotFoundException('Task '.$id.' not Found');
        }
        return $this->render('KnibTodoBundle:Default:show.html.twig', array('task' => $task));
    }
    
    public function closeAction($id){
        $rep = $this->getDoctrine()->getManager();
        $task = $rep->getRepository('KnibTodoBundle:Task')->find($id);
        if (!$task) {
            throw $this->createNotFoundException('Task '.$id.' not Found');
        }
        $task->setIsDone(1);
        $rep->flush();
        return $this->redirect($this->generateUrl('knib_todo_homepage'));
    }
    
    public function deleteAction($id){
        $rep = $this->getDoctrine()->getManager();
        $task = $rep->getRepository('KnibTodoBundle:Task')->find($id);
        if (!$task) {
            throw $this->createNotFoundException('Task '.$id.' not Found');
        }
        $rep->remove($task);
        $rep->flush();
        return $this->redirect($this->generateUrl('knib_todo_homepage'));
    }
    
    public function signinAction(Request $request){
            $session = $request->getSession();
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
            return $this->render('KnibTodoBundle:Default:signin.html.twig', array('last_username' => $session->get(SecurityContext::LAST_USERNAME),
                     'error' => $error,));
    }
    
    public function registrationAction(Request $request)
    {
            $user = new User();
            $form = $this->createForm(new UserType(), $user);
            if ($request->isMethod('POST')) {
                    $form->handleRequest($request);
                    if ($form->isValid()) {
                            $factory = $this->get('security.encoder_factory');
                            $encoder = $factory->getEncoder($user);
                            $user->encodePassword($encoder);

                            $em = $this->get('doctrine')->getManager();
                            $em->persist($user);
                            $em->flush();
                            return $this->redirect($this->generateUrl('knib_todo_homepage'));
                    }
            }
             return $this->render('KnibTodoBundle:Default:registration.html.twig', array('form' => $form->createView()));
    }
}
