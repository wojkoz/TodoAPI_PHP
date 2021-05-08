<?php

namespace App\Controller;

use App\Dto\TodoDto;
use App\Services\ITodoService;
use App\Form\Type\TodoCreateType;
use App\Controller\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractApiController
{
    private ITodoService $service;

    public function __construct(ITodoService $service){
        $this->service = $service;
    }

    /**
     * @Route("/api/user/{userId}/todo", name="getTodos", methods={"GET"})
     * @return Response
     */
    public function getTodos($userId): Response
    {
        $todoDtoList = $this->service->getTodosByUserId($userId);

        return $this->respond($todoDtoList);
    }

    /**
     * @Route("/api/user/{userId}/todo", name="addTodo", methods={"POST"})
     *
     */
    public function addTodo(Request $request, int $userId){

        $form = $this->buildForm(TodoCreateType::class);
        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }
        
        $dto = $this->service->addTodo($form->getData(), $userId);

        if($dto === null){
            return $this->respond("Couldn't find user", Response::HTTP_NOT_FOUND);
        }

        return $this->respond($dto, Response::HTTP_CREATED);

    }

    /**
     * @Route("/api/user/{userId}/todo/{todoId}", name="deleteTodo", methods={"DELETE"})
     *
     */
    public function deleteTodo(int $todoId, int $userId){
       $dto = $this->service->deleteTodo($todoId);

       if($dto === null){
           return new Response("", Response::HTTP_NOT_FOUND);
       }

        return $this->respond($dto);
    }
}
