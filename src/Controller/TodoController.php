<?php

namespace App\Controller;

use App\Dto\TodoDto;
use App\Services\ITodoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/todo", name="todo.")
 */
class TodoController extends AbstractController
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
    public function addTodo(Request $request){
        $content = json_decode($request->getContent(), true);
        
        $dto = $this->service->addTodo($content);

        if($dto === null){
            return new Response("Couldn't find user", Response::HTTP_NOT_FOUND);
        }

        return new Response(json_encode($dto, Response::HTTP_CREATED));

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

        return new Response(json_encode($dto, Response::HTTP_CREATED));
    }
}
