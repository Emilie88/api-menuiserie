<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;


    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }


    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {

        $payload = $event->getData();
        $user = $event->getUser();


        if (!$user instanceof UserInterface) {
            return;
        }

        if ($user instanceof User) {
            // $payload['data'] = array(
            $payload['id'] = $user->getId();
            $payload['email']     = $user->getEmail();
            $payload['roles']     = $user->getRoles();
            $payload['firstName']     = $user->getFirstname();
            $payload['lastName']     = $user->getLastName();
            // );
        }

        $event->setData($payload);
    }
}
