<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserCreateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends AbstractApiController
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
        $form = $this->buildForm(UserCreateType::class);
        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
                return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var UserCreateDto $content */
        $content = $form->getData();
        
        $userFound = $repository->findOneByEmail($content->username);

        if($userFound !== null){
           return $this->respond(null, Response::HTTP_CONFLICT);
        }
        
        $user = new User();
        $user->setEmail($content->username);
        $user->setPassword($encoder->encodePassword($user, $content->password));
        $user->setRoles(["ROLE_USER"]);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->respond();
    }
}
