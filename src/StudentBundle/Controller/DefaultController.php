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
use Symfony\Component\Validator\Constraints\DateTime;

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
        $content = $engine->render('StudentBundle::index.html.twig', array('deadline'=> '2015-12-13','year'=>'2015', 'medium'=>'Sinhala' , 'fullName'=> 'Yasas Pramusitha Senarath', 'indexNo'=>'1154678882', 'marks'=>125));

        return $response = new Response($content);
    }

    /**
     * @Route("/ad", name="homepage_ad")
     */
    public function indexAfterDeadlineAction()
    {
        // return $this->render('StudentBundle::index.html.twig'); // ==
        $engine = $this->container->get('templating');
        $content = $engine->render('StudentBundle::indexAfterDeadline.html.twig', array('selectedSchool'=> 'Nalanda College, Colombo 10','year'=>'2015', 'medium'=>'Sinhala' , 'fullName'=> 'Mikila Shehan Wickramarathne', 'indexNo'=>'1154678882', 'marks'=>175));

        return $response = new Response($content);
    }

    /**
     * @Route("/district", name="district_cutoff")
     */
    public function districtCutoffAction()
    {
        // return $this->render('StudentBundle::index.html.twig'); // ==
        $engine = $this->container->get('templating');
        $content = $engine->render('StudentBundle::districtCutoff.html.twig');

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
        $medium = array('Sinhala'=>'Sinhala',  'Tamil'=>'Tamil');
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
        $medium = array('Sinhala'=>'Sinhala',  'Tamil'=>'Tamil');
        $gender = array('Male'=>'Male', 'Female'=>'Female');
        $form = $this->createFormBuilder($application)
            ->add('name', TextType::class, array('attr' => array('readonly' => 'true'),))
            ->add('currentSchool', ChoiceType::class, array(
                'choices' => array($schools['Sinhala']['Mix School']),
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
        $schools = $inMem->getSchool();

        if ($inMem->getEndDate() > strtotime(date("Y-m-d"))) {
            // return $this->render('StudentBundle::index.html.twig'); // ==
            $engine = $this->container->get('templating');

            $content = $engine->render('StudentBundle::explore.html.twig', array('schoolCutoff'=>$schools));
            return $response = new Response($content);
        } else {
            return new Response('<html><body>Expired!</body></html>');
        }
    }
}
