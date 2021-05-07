<?php

namespace App\Controller;

use App\Dto\TodoDto;
use App\Services\ITodoService;
use App\Form\Type\TodoCreateType;
use App\Controller\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//TODO: fix routes /api/user/{userId}/todo instead of /api/todo/{userId} 

/**
 * @Route("/api/todo", name="todo.")
 */
class TodoController extends AbstractApiController
{
    private ITodoService $service;

    public function __construct(ITodoService $service){
        $this->service = $service;
    }

    /**
     * @Route("/{userId}", name="getTodo", methods={"GET"})
     * @return Response
     */
    public function getTodos($userId): Response
    {
        $todoDtoList = $this->service->getTodosByUserId($userId);

        return $this->respond($todoDtoList);
    }

    /**
     * @Route("", name="addTodo", methods={"POST"})
     *
     */
    public function addTodo(Request $request){

        $form = $this->buildForm(TodoCreateType::class);
        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            dump($form->getData());
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        $content = json_decode($request->getContent(), true);
        
        $dto = $this->service->addTodo($content);

        if($dto === null){
            return $this->respond("Couldn't find user", Response::HTTP_NOT_FOUND);
        }

        return $this->respond($dto, Response::HTTP_CREATED);

    }

    /**
     * @Route("/{todoId}", name="deleteTodo", methods={"DELETE"})
     *
     */
    public function deleteTodo($todoId){
       $dto = $this->service->deleteTodo($todoId);

       if($dto === null){
           return new Response("", Response::HTTP_NOT_FOUND);
       }

        return $this->respond($dto);
    }
}
