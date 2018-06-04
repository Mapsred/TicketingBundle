<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 04/06/2018
 * Time: 19:56
 */

namespace Maps_red\TicketingBundle\Utils;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TicketingHelper
{
    /** @var TokenStorageInterface $tokenStorage */
    private $tokenStorage;

    /** @var AuthorizationCheckerInterface $authorizationChecker */
    private $authorizationChecker;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @return UserInterface|null
     */
    public function getUser()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }

    /**
     * @param $role
     * @return bool
     */
    public function isGranted($role)
    {
        return $this->authorizationChecker->isGranted($role);
    }

}