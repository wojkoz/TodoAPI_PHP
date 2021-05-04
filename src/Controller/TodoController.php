<?php

namespace App\Controller;

use App\Dto\TodoDto;
use App\Entity\Todo;
use App\Entity\User;
use App\Repository\TodoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/todo", name="todo.")
 */
class TodoController extends AbstractController
{
    /**
     * @Route("/{userId}", name="getTodo", methods={"GET"})
     * @return Response
     */
    public function getTodos(TodoRepository $repository, $userId): Response
    {
        $todos = $repository->findByUserId($userId);
        

        $toTodoDto = function(Todo $todo){
            $dto = new TodoDto();
            
            $dto->id = $todo->getId();
            $dto->title = $todo->getTitle();
            $dto->description = $todo->getDescription();
            $dto->userId = $todo->getUserId()->getId();

            return $dto;
        };
        
        $todoDtoList = array_map($toTodoDto, $todos);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($todoDtoList));

        return $response;
    }

    /**
     * @Route("", name="addTodo", methods={"POST"})
     *
     */
    public function addTodo(Request $request, EntityManagerInterface $em, UserRepository $userRepository, TodoRepository $todoRepository){
        $content = json_decode($request->getContent(), true);
        $userFound = $userRepository->find($content["userId"]);

        if($userFound === null){
            return new Response("Couldn't fin user", Response::HTTP_NOT_FOUND);
        }

        $todo = new Todo();
        $todo
            ->setTitle($content["title"])
            ->setDescription($content["description"]);
        $userFound->addTodo($todo);

        $em->persist($todo);
        $em->flush();

        $savedTodo = $todoRepository->findOneBy(
            array(
                "title" => $content["title"],
                "description" => $content["description"],
                "userId" => $content["userId"]),
            array("id" => "DESC")
        );
        $dto = new TodoDto();
        $dto->id = $savedTodo->getId();
        $dto->title = $savedTodo->getTitle();
        $dto->description = $savedTodo->getDescription();
        $dto->userId = $content["userId"];

        return new Response(json_encode($dto, Response::HTTP_CREATED));

    }

    /**
     * @Route("/{todoId}", name="deleteTodo", methods={"DELETE"})
     *
     */
    public function deleteTodo($todoId, EntityManagerInterface $em, TodoRepository $todoRepository){
        $todo = $todoRepository->findOneBy(array("id" => $todoId));
        if($todo === null){
            return new Response("", Response::HTTP_NOT_FOUND);
        }

        $dto = new TodoDto();
        $dto->id = $todo->getId();
        $dto->title = $todo->getTitle();
        $dto->description = $todo->getDescription();
        $dto->userId = $todo->getUserId()->getId();
        
        $em->remove($todo);
        $em->flush();

        return new Response(json_encode($dto, Response::HTTP_CREATED));
    }
}
