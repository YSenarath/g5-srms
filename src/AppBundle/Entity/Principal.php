<?php
/**
 * Created by PhpStorm.
 * User: Yasas
 * Date: 12/21/2015
 * Time: 7:17 AM
 */

namespace AppBundle\Entity;

class Principal
{
    protected $userName;
    protected $password;

    function __construct($userName, $password)
    {
        $this->userName = $userName;
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
}