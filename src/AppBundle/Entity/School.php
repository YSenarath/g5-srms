<?php

/**
 * Created by PhpStorm.
 * User: Yasas
 * Date: 12/20/2015
 * Time: 12:58 PM
 */
namespace AppBundle\Entity;

class School
{
    public $name;
    public $address;
    public $cutoff;
    public $principal;
    public $noOfStudents;

    function __construct($name, $address, $cutoff) {
        $this->name = $name;
        $this->address = $address;
        $this->cutoff = $cutoff;
        $this->principal = null;
        $this->noOfStudents = 0;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getCutoff()
    {
        return $this->cutoff;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setCutoff($cutoff)
    {
        $this->cutoff = $cutoff;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrincipal()
    {
        return $this->principal;
    }

    public function setPrincipal($principal)
    {
        $this->principal = $principal;
    }

    public function getNoOfStudents()
    {
        return $this->noOfStudents;
    }

    public function setNoOfStudents($noOfStudents)
    {
        $this->noOfStudents = $noOfStudents;
    }
}