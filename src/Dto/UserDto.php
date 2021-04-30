<?php
namespace App\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class UserDto{
    public $id;
    public $email;
    public $todos;

    public function __construct()
    {
        $this->todos = array();
    }    
}