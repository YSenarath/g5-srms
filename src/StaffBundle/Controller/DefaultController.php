<?php

namespace StaffBundle\Controller;

use AppBundle\Controller\InMemoryStorage;
use AppBundle\Entity\Principal;
use AppBundle\Entity\School;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/staff")
     */
    public function studentAction()
    {
        $deadline = date("Y-m-d", InMemoryStorage::getInstance()->getEndDate());
        return $this->render('@Staff/index.html.twig', array('deadline'=>$deadline));
    }

    /**
     * @Route("/staff_cutoffMarks", name="cutoffPage")
     * @param Request $request
     * @return Response
     */
    public function cutoffAction(Request $request)
    {
        return $this->generateCutoffAddForm($request);
    }

    /**
     * @Route("/staff_initSystem", name="initSystemPage")
     * @param Request $request
     * @return Response
     */
    public function initSystemAction(Request $request)
    {
        return new Response('<b>System Initiated</b>');
    }

    /**
     * @Route("/staff_resetPassword", name="resetPasswordPage")
     * @param Request $request
     * @return Response
     */
    public function resetPasswordAction(Request $request)
    {
        return $this->generateCutoffAddForm($request);
    }

    /**
     * @Route("/staff_changeDeadline", name="changeDeadlinePage")
     * @param Request $request
     * @return Response
     */
    public function changeDeadlineAction(Request $request)
    {
        return $this->generateDeadlineForm($request);
    }

    /**
     * @Route("/addSchool", name="addSchoolPage")
     * @param Request $request
     * @return Response
     */
    public function addSchoolAddForm(Request $request) {
        $schollStates = array("National"=>'National', "Primary"=> 'Primary');
        $schollType = array("Boys School"=>'Boys School', "Girls School"=> 'Girls School', 'Mix School');
        $school = new School('','', '' , 0);
        $form = $this->createFormBuilder($school)
            ->add('name',TextType::class, array('label' => 'School Name'))
            ->add('address', TextType::class, array())
            ->add('type', ChoiceType::class, array('label'=> 'School Type', 'choices' => $schollType))
            ->add('status', ChoiceType::class, array('label'=> 'School Status', 'choices' => $schollStates))

            ->add('save', SubmitType::class, array('label' => 'Next'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            InMemoryStorage::getInstance()->addSchool($school);
        }

        return $this->render('StaffBundle::addSchool.html.twig', array(
            'form' => $form->createView(),
            'readonly' => true,
        ));
    }


    /**
     * @Route("/addEmployee", name="addEmployeePage")
     * @param Request $request
     * @return Response
     */
    public function addEmployeeAddForm(Request $request) {
        $eStates = array("Principal"=>'Principal', "Clerk"=> 'Clerk');
        $school = new School('','', '' , 0);
        $form = $this->createFormBuilder($school)
            ->add('no',TextType::class, array('label' => 'Employee ID'))
            ->add('name',TextType::class, array('label' => 'Employee Name'))
            ->add('address', TextType::class, array())
            ->add('type', ChoiceType::class, array('label'=> 'Employee Position', 'choices' => $eStates))
            ->add('status', EmailType::class, array('label'=> 'Email'))
            ->add('principal', IntegerType::class, array('label'=> 'Contact No'))

            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            InMemoryStorage::getInstance()->addSchool($school);
        }

        return $this->render('StaffBundle::addEmployee.html.twig', array(
            'form' => $form->createView(),
            'readonly' => true,
        ));
    }

    /**
     * @Route("/addPrincipal", name="assignPrincipalPage")
     * @param Request $request
     * @return Response
     */
    public function assignPrincipalForm(Request $request) {
        $school = InMemoryStorage::getInstance()->getSchools();
        $p = new Principal('','');
        $form = $this->createFormBuilder($p)
            ->add('schoolname',ChoiceType::class, array('label' => 'School Name' , 'choices'=>$school))
            ->add('save', SubmitType::class, array('label' => 'Generate Account'))

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            InMemoryStorage::getInstance()->addSchool($school);
        }

        return $this->render('StaffBundle::assignPrincipal.html.twig', array(
            'form' => $form->createView(),
            'readonly' => true,
        ));
    }

    public function generateCutoffAddForm($request) {
        $schools = InMemoryStorage::getInstance()->getSchools();
        $school = new School('','', '' , 0);
        $form = $this->createFormBuilder($school)
            ->add('name', ChoiceType::class, array('label' => 'School Name' , 'choices' =>$schools))
            ->add('medium', ChoiceType::class, array('choices'=> array('Sinhala'=>'Sinhala',  'Tamil'=>'Tamil')))
            ->add('cutoff', IntegerType::class, array())

            ->add('Save', SubmitType::class, array('label' => 'Update/Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            InMemoryStorage::getInstance()->addSchool($school);
        }

        return $this->render('StaffBundle::cutoff.html.twig', array(
            'form' => $form->createView(),
            'readonly' => true,
        ));
    }

    public function generateDeadlineForm($request) {
        $storage = InMemoryStorage::getInstance();
        $form = $this->createFormBuilder($storage)
            ->add('deadline', DateType::class, array('label' => 'Deadline'))
            ->add('Save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            InMemoryStorage::getInstance()->setEndDate(strtotime(date_format($storage->deadline, 'Y-m-d')));
        }

        return $this->render('StaffBundle::basicForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
