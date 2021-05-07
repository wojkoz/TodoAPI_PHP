<?php
declare(strict_types=1);
namespace App\Dto;

class TodoCreateDto{
    
    public string $title;
    public string $description;
    public int $userId;

    public function __construct(){

    }

}