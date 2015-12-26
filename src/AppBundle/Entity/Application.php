<?php
/**
 * Created by PhpStorm.
 * User: Yasas
 * Date: 12/20/2015
 * Time: 1:19 PM
 */
namespace AppBundle\Entity;

class Application
{
    public $name;
    public $currentSchool;

    public $educationalZone;
    public $medium;
    public $gender;
    public $birthday;
    public $guardiansName;
    public $address;

    public $studentIndex;
    public $marks;

    public $appliedSchools;

    public $approved;
    public $comment;

    function __construct($studentIndex, $marks)
    {
        $this->studentIndex = $studentIndex;
        $this->marks = $marks;
        $this->name = '';
        $this->appliedSchools = array();
        $this->approved = false;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getMarks()
    {
        return $this->marks;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStudentIndex()
    {
        return $this->studentIndex;
    }

    public function setMarks($marks)
    {
        $this->marks = $marks;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setStudentIndex($studentIndex)
    {
        $this->studentIndex = $studentIndex;
    }

    public function getAppliedSchools()
    {
        return $this->appliedSchools;
    }

    public function setAppliedSchools($appliedSchools)
    {
        $this->appliedSchools = $appliedSchools;
    }

    public function addAppliedSchools(School $appliedSchools)
    {
        $this->appliedSchools[] = $appliedSchools;
    }

    public function removeAppliedSchools(School $appliedSchools)
    {
        $this->appliedSchools->removeElement($appliedSchools);
    }

    public function getCurrentSchool()
    {
        return $this->currentSchool;
    }

    public function setCurrentSchool(School $currentSchool)
    {
        $this->currentSchool = $currentSchool;
    }

    public function getApproved()
    {
        return $this->approved;
    }

    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * @return mixed
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * @param mixed $medium
     */
    public function setMedium($medium)
    {
        $this->medium = $medium;
    }

    /**
     * @return mixed
     */
    public function getEducationalZone()
    {
        return $this->educationalZone;
    }

    /**
     * @param mixed $educationalZone
     */
    public function setEducationalZone($educationalZone)
    {
        $this->educationalZone = $educationalZone;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getGuardiansName()
    {
        return $this->guardiansName;
    }

    /**
     * @param mixed $guardiansName
     */
    public function setGuardiansName($guardiansName)
    {
        $this->guardiansName = $guardiansName;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
}