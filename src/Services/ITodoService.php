<?php
namespace App\Services;

use App\Dto\TodoDto;

interface ITodoService {
    public function getTodosByUserId($userId) : array;
    public function addTodo($requestContent) : ?TodoDto;
    public function deleteTodo($todoId) : ?TodoDto;
}