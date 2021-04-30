<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/api/register", name="register", methods={"POST"})
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $content = json_decode($request->getContent(), true);
        dump($content["username"]);
        // $user = new User();
        // $user->setEmail("a@a.pl");
        // $user->setPassword("123");

        // $entityManager->persist($user);
        // $entityManager->flush();

        $response = new Response();

        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }
}
