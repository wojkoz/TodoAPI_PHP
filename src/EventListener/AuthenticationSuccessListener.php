<?php
namespace App\EventListener;

use App\Dto\UserDto;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener {

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $userDto = new UserDto();

        $userDto->id = $user->getId();
        $userDto->email = $user->getEmail();
        $userDto ->todos = $user->getTodos()->getValues();

        $data['user'] = $userDto;

        $event->setData($data);
    }
}