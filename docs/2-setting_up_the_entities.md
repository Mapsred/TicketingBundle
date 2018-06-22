Step 2 - Entity Management
=================

### A - Extending the entities

TicketingBundle use ``Interface`` instead of ``Class`` for its entities. This way you can easily 
override it from the Interface if need be.

Here is an example to how to extend the ``Ticket`` Entity :

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Entity\Ticket as BaseTicket;

/**
 * @ORM\Table(name="ticket_tickets")
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket extends BaseTicket
{

}
```

### B - Fill the doctrine configuration

You will also need to explain to doctrine which Interface is which Class with the following configuration.

As it is only an example, feel free to customize it to match to your project.

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
            Symfony\Component\Security\Core\User\UserInterface: App\Entity\User
```

### C - Extend the repository

You wil need to extend the repository on your project. You can see the example of ``TicketRepository`` below. 

````php
<?php

namespace App\Repository;

use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Maps_red\TicketingBundle\Repository\TicketRepository as BaseTicketRepository;

/**
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends BaseTicketRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ticket::class);
    }
}
````

### Continue to the next step
[Step 3 - Configuration explaination](3-setting_up_the_configuration.md)