<?php

namespace StaffBundle\Controller;

use AppBundle\Controller\InMemoryStorage;
use AppBundle\Entity\Principal;
use AppBundle\Entity\School;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
     * @Route("/staff/cutoffMarks", name="cutoffPage")
     * @param Request $request
     * @return Response
     */
    public function cutoffAction(Request $request)
    {
        return $this->generateCutoffAddForm($request);
    }

    /**
     * @Route("/staff/initSystem", name="initSystemPage")
     * @param Request $request
     * @return Response
     */
    public function initSystemAction(Request $request)
    {
        return new Response('<b>System Initiated</b>');
    }

    /**
     * @Route("/staff/resetPassword", name="resetPasswordPage")
     * @param Request $request
     * @return Response
     */
    public function resetPasswordAction(Request $request)
    {
        return $this->generateCutoffAddForm($request);
    }

    /**
     * @Route("/staff/changeDeadline", name="changeDeadlinePage")
     * @param Request $request
     * @return Response
     */
    public function changeDeadlineAction(Request $request)
    {
        return $this->generateDeadlineForm($request);
    }

    public function generateCutoffAddForm($request) {
        $school = new School('', '' , 0);
        $form = $this->createFormBuilder($school)
            ->add('name', TextType::class, array('label' => 'School Name'))
            ->add('address', TextareaType::class, array())
            ->add('principal', TextType::class, array())
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
