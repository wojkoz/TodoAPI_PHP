<?php
declare(strict_types=1);
namespace App\Dto;

class UserCreateDto{
    public string $username;
    public string $password;

    public function __construct(){

    }
}
