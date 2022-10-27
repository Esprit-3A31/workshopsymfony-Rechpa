<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use App\Form\StudentType;
use App\Entity\Student;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SubmitType;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/studentList', name: 'list_student')]
    public function listStudent(StudentRepository $repository){
        $student=$repository->findAll();
        return $this->render("student/list.html.twig",
        array('list_stud'=>$student));
    }

    #[Route('/studentAdd', name: 'studentAdd')]
    public function addStudent(StudentRepository $repo,Request  $request,ManagerRegistry $doctrine)
    {
        $student= new  Student();
        $form= $this->createForm(StudentType::class,$student);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
             $repo->add($student, flush:true);
             return  $this->redirectToRoute("studentAdd");
         }
        return $this->renderForm("student/add.html.twig",array("form_student"=>$form));
    }

    
    #[Route('/studentref', name: 'list_student')]
    public function FindByref(StudentRepository $repository){
        $student=$repository->sortByref();
        $moyenne=$repository->topStudent();
        return $this->render("student/list.html.twig",
        array("sortByReference"=>$student,"topstudent"=>$moyenne));
    }
 
    

}
