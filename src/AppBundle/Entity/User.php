<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $verifed;

    public function __construct()
    {
        parent::__construct();
        
        $this->verifed = false;
    }

    public function setVerifed($boolean)
    {
        $this->verifed = (bool) $boolean;

        return $this;
    }

    public function getVerifed()
    {
        return $this->verifed;
    }
}