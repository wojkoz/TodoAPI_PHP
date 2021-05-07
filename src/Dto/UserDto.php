<?php
declare(strict_types=1);
namespace App\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class UserDto{
    public int $id;
    public string $email;
    public array $todos;

    public function __construct()
    {
        $this->todos = array();
    }    
}