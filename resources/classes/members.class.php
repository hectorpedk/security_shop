<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dimul
 * Date: 23/05/13
 * Time: 14:07
 * To change this template use File | Settings | File Templates.
 */

namespace Resources\Classes;


class Members {

    private $id,
            $role_id,
            $name,
            $lastname,
            $email,
            $username,
            $password,
            $salt;

    function __construct( $id = 0 )
    {

    }


    /**
     * @param string $lastname
     *
     */
    public function setLastname( $lastname )
    {
        $this->lastname = $lastname;
    }

    public function setName( $name )
    {
        $this->name = $name;
    }

    public function setEmail ( $email )
    {
        $this->email = $email;
    }

    public function setUsername( $username )
    {
        $this->username = $username;
    }

    public function setPassword( $password )
    {
        $this->password = $password;
    }

    public function setSalt( $salt )
    {
        $this->salt = $salt;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

}