<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/todo", name="todo.")
 */
class TodoController extends AbstractController
{
    /**
     * @Route("/", name="getTodo")
     * @return Response
     */
    public function getTodos(): Response
    {
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode(['message' => 'Welcome to your new controller!', 'path' => 'src/Controller/TodoController.php']));

        return $response;

        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/TodoController.php',
        // ]);
    }
}
