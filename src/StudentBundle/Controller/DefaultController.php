<?php

namespace StudentBundle\Controller;

use AppBundle\Controller\InMemoryStorage;
use AppBundle\Entity\Application;
use AppBundle\Entity\School;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    function __construct() {
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // return $this->render('StudentBundle::index.html.twig'); // ==
        $engine = $this->container->get('templating');
        $content = $engine->render('StudentBundle::index.html.twig', array('indexNo'=>'1154678882', 'marks'=>125));

        return $response = new Response($content);
    }

    /**
     * @Route("/apply", name="applypage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function applyAction(Request $request)
    {
        $inMem = InMemoryStorage::getInstance();
        $student = $inMem->getStudents()[0];
        if ($inMem->getEndDate() > strtotime(date("Y-m-d"))) {
            return $this->generateWritableApplicationForm($request, $inMem, $student);
        } else {
            return $this->generateReadOnlyApplicationForm($request, $inMem, $student);
        }
    }

    public function generateWritableApplicationForm($request, $inMem, $student) {
        $application = $student->getApplication();
        $schools = $inMem->getSchools();
        $medium = array('sinhala'=>'Sinhala', 'English'=>'English', 'Tamil'=>'Tamil');
        $gender = array('Male'=>'Male', 'Female'=>'Female');
        $form = $this->createFormBuilder($application)
            ->add('name', TextType::class, array())
            ->add('currentSchool', ChoiceType::class, array(
                'choices' => $schools,
                'choices_as_values' => true,))
            ->add('medium', ChoiceType::class, array(
                'choices' => $medium,
                'choices_as_values' => true,))
            ->add('gender', ChoiceType::class, array(
                'choices' => $gender,
                'choices_as_values' => true,))
            ->add('birthday', DateType::class, array(
                'input'  => 'timestamp',
                'widget' => 'choice',))
            ->add('guardiansName', TextType::class, array())
            ->add('address', TextType::class, array())

            ->add('studentIndex', TextType::class, array('attr' => array('readonly' => 'true'),))
            ->add('marks', IntegerType::class, array('attr' => array('readonly' => 'true'),))
            ->add('appliedSchools', CollectionType::class, array(
                'entry_type'   => ChoiceType::class,
                'entry_options'  => array(
                    'choices' => $schools,
                    'choices_as_values' => true,),
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('Save', SubmitType::class, array('label' => 'Update/Create Application'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('StudentBundle::application.html.twig', array(
            'form' => $form->createView(),
            'readonly' => false,
        ));
    }

    public function generateReadOnlyApplicationForm($request, $inMem, $student) {
        $application = $student->getApplication();
        $schools = $inMem->getSchools();
        $medium = array('sinhala'=>'Sinhala', 'English'=>'English', 'Tamil'=>'Tamil');
        $gender = array('Male'=>'Male', 'Female'=>'Female');
        $form = $this->createFormBuilder($application)
            ->add('name', TextType::class, array('attr' => array('readonly' => 'true'),))
            ->add('currentSchool', ChoiceType::class, array(
                'choices' => $schools,
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
            ->add('guardiansName', TextType::class, array('attr' => array('readonly' => 'true'),))
            ->add('address', TextType::class, array('attr' => array('readonly' => 'true'),))

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
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Action
        }

        return $this->render('StudentBundle::application.html.twig', array(
            'form' => $form->createView(),
            'readonly' => true,
        ));
    }

    /**
     * @Route("/explore", name="explorepage")
     */
    public function exploreAction()
    {
        $inMem = InMemoryStorage::getInstance();
        $schools = $inMem->getSchools();

        if ($inMem->getEndDate() > strtotime(date("Y-m-d"))) {
            // return $this->render('StudentBundle::index.html.twig'); // ==
            $engine = $this->container->get('templating');
            $content = $engine->render('StudentBundle::explore.html.twig', array('schools'=>$schools));
            return $response = new Response($content);
        } else {
            return new Response('<html><body>Expired!</body></html>');
        }
    }
}
