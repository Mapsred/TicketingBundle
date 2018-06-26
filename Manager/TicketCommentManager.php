<?php

namespace Maps_red\TicketingBundle\Manager;

use Maps_red\TicketingBundle\Model\TicketInterface;
use Maps_red\TicketingBundle\Repository\TicketCommentRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TicketCommentManager
 * @package Maps_red\TicketingBundle\Manager
 * @method TicketCommentRepository getRepository
 */
class TicketCommentManager extends AbstractManager
{
    public function verifyPublicLimit(TicketInterface $ticket, UserInterface $user)
    {
        $lasts = $this->getRepository()->findLastTwoByTicket($ticket);

        if (!is_array($lasts) || count($lasts) != 2) {
            return true;
        }

        if ($lasts[0]->getAuthor() === $user && $lasts[1]->getAuthor() === $user) {
            return false;
        }

        return true;
    }

}