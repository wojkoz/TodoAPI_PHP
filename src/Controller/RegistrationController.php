<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/register", name="registrer")
*/
class RegistrationController extends AbstractController
{
    /**
     * @Route("/", name="registrer")
     */
    public function register(): Response
    {

        $response = new Response();

        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }
}
