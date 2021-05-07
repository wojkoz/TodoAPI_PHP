<?php
namespace App\Services;

use App\Dto\TodoDto;
use App\Entity\Todo;
use App\Services\ITodoService;
use App\Repository\TodoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class TodoService implements ITodoService{
    private TodoRepository $todoRepository;
    private UserRepository $userRepository;
    private EntityManagerInterface $em;

    /**
     * @required
     */
    public function __contruct(TodoRepository $todoRepository, EntityManagerInterface $em, UserRepository $userRepository){
        $this->todoRepository = $todoRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    public function getTodosByUserId($userId): array{
        $todos = $this->todoRepository->findByUserId($userId);
        

        $toTodoDto = function(Todo $todo){
            return $this->mapToTodoDto($todo);
        };
        
        return $todoDtoList = array_map($toTodoDto, $todos);
    }

    
    public function addTodo($requestContent) : ?TodoDto{
        $userFound = $this->userRepository->find($requestContent["userId"]);

        if($userFound === null){
            return null;
        }

        $todo = new Todo();
        $todo
            ->setTitle($requestContent["title"])
            ->setDescription($requestContent["description"]);
        $userFound->addTodo($todo);

        $this->em->persist($todo);
        $this->em->flush();

        $dto = $this->mapToTodoDto($todo);

        return $dto;
    }
    
    public function deleteTodo($todoId) : ?TodoDto{
        $todo = $this->todoRepository->findOneBy(array("id" => $todoId));
        if($todo === null){
            return null;
        }

        $dto = $this->mapToTodoDto($todo);
        
        $this->em->remove($todo);
        $this->em->flush();

        return $dto;
    }

    private function mapToTodoDto($todo) : TodoDto{
        $dto = new TodoDto();
        $dto->id = $todo->getId();
        $dto->title = $todo->getTitle();
        $dto->description = $todo->getDescription();
        $dto->userId = $todo->getUserId()->getId();

        return $dto;
    }
}