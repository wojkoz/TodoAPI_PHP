<?php

namespace App\Controller;

use App\Dto\TodoDto;
use App\Entity\Todo;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/todo", name="todo.")
 */
class TodoController extends AbstractController
{
    /**
     * @Route("/{userId}", name="getTodo")
     * @return Response
     */
    public function getTodos(EntityManagerInterface $entityManager, $userId): Response
    {
        $user = $entityManager->find("User", $userId);
        $response = new Response();

        if($user === null){
            $response->setStatusCode(Response::HTTP_NO_CONTENT, "Couldn't find user");
            return $response;
        }

        $toTodoDto = function(Todo $todo){
            $dto = new TodoDto();
            
            $dto->id = $todo->getId();
            $dto->title = $todo->getTitle();
            $dto->description = $todo->getDescription();
            $dto->userId = $todo->getUserId();

            return $dto;
        };
        
        $todoDtoList = array_map($toTodoDto, $user->getTodos());
        dump($todoDtoList);

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($todoDtoList));

        return $response;
    }
}
