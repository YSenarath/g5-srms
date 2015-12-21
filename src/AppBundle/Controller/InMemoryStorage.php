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
    protected $endDate;
    public $deadline;

    protected function __construct()
    {
        $this->students = array();
        $this->schools = array();
        $this->endDate = strtotime('2015-02-05');
        // *--------------------Initialize  Memory-----------------------------------------* //
        $this->students[] = new Student(123456789, 'psss', 152);
        $this->students[] = new Student(159456789, 'p1', 125);
        $this->students[] = new Student(158746589, 'pass2', 180);
        $this->students[] = new Student(785556685, 'p2', 75);

        $school = new School('Royal College', 'Colombo', 179);
        $school->setPrincipal(new Principal('principal of RC', 'pass'));
        $this->schools[$school->name] = $school;

        $school = new School('Bandaranayake College', 'Gampaha', 150);
        $school->setPrincipal(new Principal('principal of bc', 'pass'));
        $this->schools[$school->name] = $school;

        $school = new School('Nalanda College', 'Minuwangoda', 125);
        $school->setPrincipal(new Principal('principal of nalanda', 'pass'));
        $this->schools[$school->name] = $school;

        $this->students[0]->getApplication()->setCurrentSchool($this->schools['Nalanda College']);
        $this->students[0]->getApplication()->setName('Yasas Pramusitha Senarath');
        $this->students[0]->getApplication()->addAppliedSchools($this->schools['Royal College']);
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
}