<?php
/**
 * Created by PhpStorm.
 * User: Yasas
 * Date: 12/20/2015
 * Time: 7:40 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Principal;
use AppBundle\Entity\School;
use AppBundle\Entity\Student;

class InMemoryStorage
{
    protected static $instance = null;

    protected $students;
    protected $schools;
    protected $schools1;
    protected $endDate;

    public $deadline;

    protected function __construct()
    {
        $this->students = array();

        $this->endDate = strtotime('2016-02-05');
        // *--------------------Initialize  Memory-----------------------------------------* //
        $this->students[] = new Student(123456789, 'psss', 152);
        $this->students[] = new Student(159456789, 'p1', 125);
        $this->students[] = new Student(158746589, 'pass2', 180);
        $this->students[] = new Student(785556685, 'p2', 75);

        $this->schools = array();
        $tempSchools = array();
        $tempMediums = array();

        //sinhala boys schools
        $school = new School('1','Royal College', 'Rajakeeya MW, Colombo 07', 186);
        $school->setPrincipal(new Principal('principal of RC', 'pass'));
        $tempSchools[$school->name] = $school;

        $school = new School('2','Ananda College', 'Colombo-10', 183);
        $school->setPrincipal(new Principal('principal of AC', 'pass'));
        $tempSchools[$school->name] = $school;

        $school = new School('3','Dharmaraja College', 'Kandy', 183);
        $school->setPrincipal(new Principal('principal of DC', 'pass'));
        $tempSchools[$school->name] = $school;


        $tempSchools1 = array();

        //sinhala girls schools
        $school = new School('1','Visakha Vidyalaya', 'Vajira RD, Colombo-05', 185);
        $school->setPrincipal(new Principal('principal of VV', 'pass'));
        $tempSchools1[$school->name] = $school;

        $school = new School('2','Mahamaya Girls\' College', 'Kandy', 183);
        $school->setPrincipal(new Principal('principal of MGC', 'pass'));
        $tempSchools1[$school->name] = $school;


        $tempSchools2 = array();

        //sinhala mix schools
        $school = new School('1','Seevali Central College', 'Hidellana, Ratnapura', 176);
        $school->setPrincipal(new Principal('principal of SC', 'pass'));
        $tempSchools2[$school->name] = $school;

        $school = new School('2','Dharmapala Vidyalaya', 'Pannipitiya', 175);
        $school->setPrincipal(new Principal('principal of DV', 'pass'));
        $tempSchools2[$school->name] = $school;

        $tempSchools['schoolType'] = 'Boys';
        $tempMediums['Boys School'] = $tempSchools;
        $tempSchools1['schoolType'] = 'Girls';
        $tempMediums['Girls School'] = $tempSchools1;
        $tempSchools2['schoolType'] = 'Mix';
        $tempMediums['Mix School'] = $tempSchools2;



        $tempMediums1 = array();

        //tamil boys schools
        $tempSchools3 = array();
        $school = new School('1','D.S.Senanayaka Vidyalaya', 'Colombo 07', 174);
        $school->setPrincipal(new Principal('principal of DSS', 'pass'));
        $tempSchools3[$school->name] = $school;

        $school = new School('2','St. Michael Vidyalaya', 'Batticalao', 173);
        $school->setPrincipal(new Principal('principal of STMV', 'pass'));
        $tempSchools3[$school->name] = $school;





        //tamil girls schools
        $tempSchools4 = array();
        $school = new School('1','Muslim Ladies College', 'Colombo-04', 174);
        $school->setPrincipal(new Principal('principal of VV', 'pass'));
        $tempSchools4[$school->name] = $school;

        $school = new School('2','St. Mary\'s College', 'Trincomalee', 161);
        $school->setPrincipal(new Principal('principal of MGC', 'pass'));
        $tempSchools4[$school->name] = $school;

        //tamil mix schools
        $tempSchools5 = array();

        $school = new School('1','Cambridge Vidyalaya', 'Kotagala', 168);
        $school->setPrincipal(new Principal('principal of CV', 'pass'));
        $tempSchools5[$school->name] = $school;

        $school = new School('2','Kokuvil Hindu Vidyalaya', 'Kokuvil', 162);
        $school->setPrincipal(new Principal('principal of KHV', 'pass'));
        $tempSchools5[$school->name] = $school;




        $tempSchools3['schoolType'] = 'Boys';
        $tempMediums1['Boys School'] = $tempSchools3;
        $tempSchools4['schoolType'] = 'Girls';
        $tempMediums1['Girls School'] = $tempSchools4;
        $tempSchools5['schoolType'] = 'Mix';
        $tempMediums1['Mix School'] = $tempSchools5;


        $tempMediums['schoolMedium'] ='Sinhala';
        $tempMediums1['schoolMedium'] = 'Tamil';
        $this->schools ['Sinhala'] = $tempMediums;
        $this->schools ['Tamil'] =  $tempMediums1;



        //sinhala boys schools
        $school = new School('1','Royal College', 'Rajakeeya MW, Colombo 07', 186);
        $school->setPrincipal(new Principal('principal of RC', 'pass'));
        $this->schools1[$school->name] = $school;

        $school = new School('2','Ananda College', 'Colombo-10', 183);
        $school->setPrincipal(new Principal('principal of AC', 'pass'));
        $this->schools1[$school->name] = $school;

        $school = new School('3','Dharmaraja College', 'Kandy', 183);
        $school->setPrincipal(new Principal('principal of DC', 'pass'));
        $this->schools1[$school->name] = $school;

        //sinhala girls schools
        $school = new School('1','Visakha Vidyalaya', 'Vajira RD, Colombo-05', 185);
        $school->setPrincipal(new Principal('principal of VV', 'pass'));
        $this->schools1[$school->name] = $school;

        $school = new School('2','Mahamaya Girls\' College', 'Kandy', 183);
        $school->setPrincipal(new Principal('principal of MGC', 'pass'));
        $this->schools1[$school->name] = $school;


        //sinhala mix schools
        $school = new School('1','Seevali Central College', 'Hidellana, Ratnapura', 176);
        $school->setPrincipal(new Principal('principal of SC', 'pass'));
        $this->schools1[$school->name] = $school;

        $school = new School('2','Dharmapala Vidyalaya', 'Pannipitiya', 175);
        $school->setPrincipal(new Principal('principal of DV', 'pass'));
        $this->schools1[$school->name] = $school;


        $school1 = new School('1', 'Dharmapala Vidyalaya', 'Pannipitiya', 186);
        $school1->setPrincipal(new Principal('principal of DV', 'pass'));

        $this->students[0]->getApplication()->setCurrentSchool($school1);
        $this->students[0]->getApplication()->setName('Yasas Pramusitha Senarath');

        $this->students[1]->getApplication()->setCurrentSchool($school1);
        $this->students[1]->getApplication()->setName('Dulanjaya Tennekoon');

        $this->students[2]->getApplication()->setCurrentSchool($school1);
        $this->students[2]->getApplication()->setName('Shehan Samarawickrama');

        $this->students[3]->getApplication()->setCurrentSchool($school1);
        $this->students[3]->getApplication()->setName('Nadheesh Jihan');

        $school2 = new School('2','Ananda College', 'Colombo-10', 183);
        $school2->setPrincipal(new Principal('principal of AC', 'pass'));

        $this->students[0]->getApplication()->addAppliedSchools($school2);
        $this->students[1]->getApplication()->addAppliedSchools($school2);
        $this->students[2]->getApplication()->addAppliedSchools($school2);
        $this->students[3]->getApplication()->addAppliedSchools($school2);
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public static function getInstance() {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function getSchools()
    {
        return $this->schools1;
    }
    public function getSchool()
    {
        return $this->schools;
    }
    public function getStudents()
    {
        return $this->students;
    }

    public function addStudent(Student $student)
    {
        $this->students[] = $student;
    }

    public function addSchool(School $school)
    {
        $this->schools[$school->name] = $school;
    }

    public function getSchoolByName($school_name) {
        return $this->schools1[$school_name];
    }
}