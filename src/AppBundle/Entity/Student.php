<?php
/**
 * Created by PhpStorm.
 * User: Yasas
 * Date: 12/20/2015
 * Time: 7:43 PM
 */

namespace AppBundle\Entity;


class Student
{
    protected $indexNumber;
    protected $password;
    protected $application;

    function __construct($indexNumber, $password, $marks)
    {
        $this->indexNumber = $indexNumber;
        $this->password = $password;
        $this->application = new Application($indexNumber, $marks);
    }

    public function setApplication($application)
    {
        $this->application = $application;
    }

    public function getApplication()
    {
        return $this->application;
    }

    public function getIndexNumber()
    {
        return $this->indexNumber;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setIndexNumber($indexNumber)
    {
        $this->indexNumber = $indexNumber;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}