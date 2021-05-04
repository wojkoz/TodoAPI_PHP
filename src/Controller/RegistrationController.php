<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends AbstractController
{

    public function __construct(){

    }
    /**
     * @Route("/api/authenticate/register", name="register", methods={"POST"})
     */
    public function register(Request $request,
                                UserRepository $repository,
                                EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $encoder): Response
    {
        $content = json_decode($request->getContent(), true);
        $userFound = $repository->findOneByEmail($content["username"]);

        $response = new Response();

        if($userFound !== null){
            $response->setStatusCode(Response::HTTP_CONFLICT);
            return $response;
        }
        
        $user = new User();
        $user->setEmail($content["username"]);
        $user->setPassword($encoder->encodePassword($user, $content["password"]));

        $entityManager->persist($user);
        $entityManager->flush();

        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }
}
