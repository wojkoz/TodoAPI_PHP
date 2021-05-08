<?php
declare(strict_types=1);
namespace App\Services;

use App\Dto\TodoDto;
use App\Dto\TodoCreateDto;

interface ITodoService {
    public function getTodosByUserId(int $userId) : array;
    public function addTodo(TodoCreateDto $todoCreateDto, int $userId) : ?TodoDto;
    public function deleteTodo(int $todoId, int $userId) : ?TodoDto;
}