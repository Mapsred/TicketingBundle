<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Maps_red\TicketingBundle\Repository\TicketRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TicketManager
 * @package Maps_red\TicketingBundle\Manager
 * @method TicketRepository getRepository
 */
class TicketManager extends AbstractManager
{
    /** @var bool $enableHistory */
    private $enableHistory;

    /** @var bool $enableTicketRestriction */
    private $enableTicketRestriction;

    /** @var string $restrictedTicketsRole */
    private $restrictedTicketsRole;

    /** @var TicketStatusManager $ticketStatusManager */
    private $ticketStatusManager;

    /** @var Security $security */
    private $security;

    /**
     * TicketManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     * @param bool $enableHistory
     * @param bool $enableTicketRestriction
     * @param string $restrictedTicketsRole
     * @param TicketStatusManager $ticketStatusManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $manager, string $class, bool $enableHistory, bool $enableTicketRestriction,
                                string $restrictedTicketsRole, TicketStatusManager $ticketStatusManager, Security $security)
    {
        parent::__construct($manager, $class);
        $this->enableHistory = $enableHistory;
        $this->enableTicketRestriction = $enableTicketRestriction;
        $this->restrictedTicketsRole = $restrictedTicketsRole;
        $this->ticketStatusManager = $ticketStatusManager;
        $this->security = $security;
    }

    /* Form Handler */

    /**
     * @param UserInterface $user
     * @param TicketInterface $ticket
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createTicket(UserInterface $user, TicketInterface $ticket)
    {
        $status = $this->ticketStatusManager->getDefaultStatus();
        $ticket->setStatus($status)->setAuthor($user)->setPublic(false);

        if (!$this->isTicketRestrictionEnabled()) {
            $ticket->setPublicAt(new \DateTime())->setPublic(true);
        }

        $this->persistAndFlush($ticket);
    }


    /* DataTables */

    /**
     * @param array $datas
     * @param string $status
     * @param string $type
     * @param UserInterface $user
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function handleDataTable(array $datas, string $status, string $type, UserInterface $user)
    {
        $columns = array_combine(
            array_column($datas['columns'], 'name'),
            array_column(array_column($datas['columns'], 'search'), 'value')
        );

        $fields = array_keys($columns);

        $columns = array_map(function ($column) {
            return $column ?: null;
        }, $columns);
        $columns = array_filter($columns);

        unset($datas['columns']);

        $order = $datas['order'][0];
        unset($datas['order']);

        $order = [$fields[$order['column']] => strtoupper($order['dir'])];

        $globalSearch = $datas['search']['value'] ?: null;
        unset($datas['search']);

        $fields = array_combine(array_values($fields), array_values($fields));
        unset($fields['status'], $fields['type'], $fields['assignated']);

        return [
            'data' => $this->getRepository()
                ->searchDataTable($globalSearch, $columns, $fields, $order, $datas['start'], $datas['length'], false, $status, $type, $user),
            'count' => $this->getRepository()
                ->searchDataTable($globalSearch, $columns, $fields, $order, $datas['start'], $datas['length'], true, $status, $type, $user)
        ];
    }

    /**
     * @param TicketInterface $ticket
     * @return array
     */
    public function toArray(TicketInterface $ticket)
    {
        return [
            'id' => $ticket->getId(),
            'author' => $ticket->getAuthor()->getUsername(),
            'createdAt' => $ticket->getCreatedAt()->format('d/m/Y'),
            'category' => $ticket->getCategory() ? $ticket->getCategory()->getName() : 'Aucune Catégorie',
            'status' => $ticket->getStatus()->getValue() . ' - ' . $ticket->getStatus()->getStyle(),
            'type' => $ticket->getPublic() ? "Public" : "Privé",
            'priority' => $ticket->getPriority() ? $ticket->getPriority()->getValue() : 'Aucune Priorité',
            'assignated' => $ticket->getAssignated() ? $ticket->getAssignated()->getUsername() : "",
        ];
    }


    /* Helpers */

    /**
     * @param TicketInterface $ticket
     * @param UserInterface $user
     * @return bool
     */
    public function isUserTicketAuthor(TicketInterface $ticket, UserInterface $user)
    {
        return $ticket->getAuthor() === $user;
    }

    /**
     * @param TicketInterface $ticket
     * @param UserInterface $user
     * @return bool
     */
    public function isTicketPrivate(TicketInterface $ticket, UserInterface $user)
    {
        if ($this->enableTicketRestriction) {
            return !$ticket->getPublic() && !$this->isTicketRestricted() && !$this->isUserTicketAuthor($ticket, $user);
        }

        return false;

    }

    /**
     * @return bool
     */
    public function isTicketRestricted()
    {
        return $this->security->isGranted($this->restrictedTicketsRole);
    }



    /**
     * @return bool
     */
    public function isTicketRestrictionEnabled(): bool
    {
        return $this->enableTicketRestriction;
    }

    /**
     * @param TicketInterface $ticket
     * @param UserInterface $user
     * @return bool
     */
    public function isTicketGranted(TicketInterface $ticket, UserInterface $user)
    {
        if ($this->isUserTicketAuthor($ticket, $user)) {
            return true;
        }

        if ($this->isTicketPrivate($ticket, $user)) {
            return $this->security->isGranted($ticket->getCategory()->getRole());
        }

        return true;
    }


}