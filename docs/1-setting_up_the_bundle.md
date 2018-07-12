Step 1 - Setting up the Bundle
======================

### Fill the doctrine configuration

You will need to explain to doctrine which Interface is which Class with the following configuration.

```yaml
# config/packages/doctrine.yaml
doctrine:
    # ...
    orm:
        # ...
        resolve_target_entities:
            Maps_red\TicketingBundle\Model\TicketInterface: App\Entity\Ticket
            Maps_red\TicketingBundle\Model\TicketCategoryInterface: App\Entity\TicketCategory
            Maps_red\TicketingBundle\Model\TicketCommentInterface: App\Entity\TicketComment
            Maps_red\TicketingBundle\Model\TicketHistoryInterface: App\Entity\TicketHistory
            Maps_red\TicketingBundle\Model\TicketKeywordInterface: App\Entity\TicketKeyword
            Maps_red\TicketingBundle\Model\TicketStatusInterface: App\Entity\TicketStatus
            Maps_red\TicketingBundle\Model\TicketPriorityInterface: App\Entity\TicketPriority
            Maps_red\TicketingBundle\Model\TicketStatusHistoryInterface: App\Entity\TicketStatusHistory
            Symfony\Component\Security\Core\User\UserInterface: App\Entity\User
```

[return to the index](../README.md)