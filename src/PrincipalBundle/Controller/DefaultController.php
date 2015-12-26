<?php

namespace PrincipalBundle\Controller;

use AppBundle\Controller\InMemoryStorage;
use AppBundle\Entity\Principal;
use AppBundle\Entity\School;
use AppBundle\Entity\Student;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/principal")
     * @param Request $request
     * @return Response|void
     */
    public function principalAction(Request $request)
    {
        return $this->render('@Principal/index.html.twig', array());
    }

    /**
     * @Route("/principal_accept", name="acceptPage")
     * @param Request $request
     * @return Response|void
     */
    public function acceptAction(Request $request)
    {
        $principal = 'principal of AC';
        $school = $this->getSchool($principal);

            return $this->studentApplicationAction($school);

    }

    /**
     * @Route("/principal_vacancies", name="vacancyPage")
     * @param Request $request
     * @return Response|void
     */
    public function regesterVacanciesAction(Request $request)
    {
        $principal = 'principal of DV';
        $school = $this->getSchool($principal);
        if (InMemoryStorage::getInstance()->getEndDate() > strtotime(date("Y-m-d"))) {
            return $this->studentCountAction($school, $request);
        }

    }

    /**
     * @Route("/principal_approve", name="approvePage")
     * @param Request $request
     * @return Response|void
     */
    public function approveAction(Request $request)
    {
        $principal = 'principal of DV';
        $school = $this->getSchool($principal);
        if (InMemoryStorage::getInstance()->getEndDate() > strtotime(date("Y-m-d"))) {
            return $this->listStudentApplicationsAction($school, false);
        } else {
            return $this->listStudentApplicationsAction($school, true);
        }
    }

    /**
     * @Route("/principal_view", name="viewPage")
     * @param Request $request
     * @return Response|void
     */
    public function viewStudentAction(Request $request)
    {
        $principal = 'principal of DV';
        $studentId = $request->query->get('id');
        $student = $this->getStudent($studentId);
        return $this->generateReadOnlyApplicationForm($request, InMemoryStorage::getInstance(), $student);
    }

    public function getSchool($principal) {
        $inMem = InMemoryStorage::getInstance();
        $schools = $inMem->getSchools();
        $school = null;
        foreach($schools as $temp){
            if ($temp->getPrincipal()->getUserName() == $principal) {
                $school = $temp;
            }
        }
        return $school;
    }

    public function getStudent($stu) {
        $inMem = InMemoryStorage::getInstance();
        $students = $inMem->getStudents();
        foreach($students as $temp){
            if ($temp->getIndexNumber() == $stu) {
                return $temp;
            }
        }
        return null;
    }

    public function getApplicationListFor(School $school) {
        $inMem = InMemoryStorage::getInstance();
        $applications = array();
        $students = $inMem->getStudents();
        foreach($students as $temp){
            $application = $temp->getApplication();
            if ($application->getName() != null && $application->getName() != "" ) {
                $appliedSchools = $application->getAppliedSchools();
                foreach($appliedSchools as $sch) {
                    if ($sch->getName() == $school->getName()) {
                        $applications[] = $application;
                    }
                }
            }
        }
        return $applications;
    }

    public function getApplicationListFrom(School $school) {
        $inMem = InMemoryStorage::getInstance();
        $applications = array();
        $students = $inMem->getStudents();
        foreach($students as $temp){
            $application = $temp->getApplication();
            if ($application->getName() != null && $application->getName() != "" ) {
                $application = $temp->getApplication();
                $currentSchool = $application->getCurrentSchool();
                if ($currentSchool != null && $currentSchool->getName() == $school->getName()) {
                    $applications[] = $application;
                }
            }
        }
        return $applications;
    }

    public function studentCountAction(School $school, Request $request) {
        $form = $this->createFormBuilder($school)
            ->add('noOfStudents', IntegerType::class,  array('label' => 'No of Vacancies'))
            ->add('Save', SubmitType::class, array('label' => 'Update Student Vacancies'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Action
        }

        $applications = $this->getApplicationListFor($school);

        return $this->render('@Principal/studentCount.html.twig', array(
            'form' => $form->createView(),
            'readonly' => true,
            'school' => $school,
            'applications' => $applications,
        ));
    }

    public function studentApplicationAction(school $school) {
        $applications = $this->getApplicationListFor($school);

        return $this->render('@Principal/listApplications.html.twig', array(
            'applications' => $applications,
            'school' => $school,
        ));
    }

    public function listStudentApplicationsAction(school $school, $dead) {
        $applications = $this->getApplicationListFrom($school);

        return $this->render('@Principal/approveStudentList.html.twig', array(
            'applications' => $applications,
            'school' => $school,
            'dead' => $dead,
        ));
    }

    /**
     * @param $request
     * @param $inMem
     * @param $student
     * @return Response
     */
    public function generateReadOnlyApplicationForm($request, $inMem, $student) {
        $application = $student->getApplication();
        $schools = $inMem->getSchools();
        $medium = array('Sinhala'=>'Sinhala', 'Tamil'=>'Tamil');
        $gender = array('Male'=>'Male', 'Female'=>'Female');
        $form = $this->createFormBuilder($application)
            ->add('name', TextType::class, array('attr' => array('readonly' => 'true'),))
            ->add('currentSchool', ChoiceType::class, array(
                'choices' => $schools,
                'data' =>  $schools['Dharmapala Vidyalaya'],
                'choices_as_values' => true,
                'attr' => array('readonly' => 'true'),))
            ->add('medium', ChoiceType::class, array(
                'choices' => $medium,
                'choices_as_values' => true,
                'attr' => array('readonly' => 'true'),))
            ->add('gender', ChoiceType::class, array(
                'choices' => $gender,
                'choices_as_values' => true,
                'attr' => array('readonly' => 'true'),))
            ->add('birthday', DateType::class, array(
                'input'  => 'timestamp',
                'widget' => 'choice',
                'attr' => array('readonly' => 'true'),))
            ->add('guardiansName', TextType::class, array('data' =>'G.D Senerathe', 'attr' => array('readonly' => 'true'),))
            ->add('address', TextType::class, array('data' =>'121/3, Dedunu MW, Pannipitiya', 'attr' => array('readonly' => 'true'),))

            ->add('studentIndex', TextType::class, array('attr' => array('readonly' => 'true'),))
            ->add('marks', IntegerType::class, array('attr' => array('readonly' => 'true'),))
            ->add('appliedSchools', CollectionType::class, array(
                'entry_type'   => ChoiceType::class,
                'entry_options'  => array(
                    'choices' => $schools,
                    'choices_as_values' => true,
                    'attr' => array('readonly' => 'true'),),
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => array('readonly' => 'true'),
            ))
            //by jnj temporary
            ->add('comment', TextareaType::class, array('label' => 'Comments' ,))


            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Action
        }

        return $this->render('@Principal/viewApplicationForm.html.twig', array(
            'form' => $form->createView(),
            'readonly' => true,
        ));
    }

}
