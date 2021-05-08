<?php
declare(strict_types=1);
namespace App\Dto;

class TodoCreateDto{
    
    public string $title;
    public ?string $description = "";

    public function __construct(){

    }

}