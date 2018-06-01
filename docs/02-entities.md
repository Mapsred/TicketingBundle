# Entity Management

To fully use this bundle you need to implement all the interfaces in the ``Model`` folder
or to extend all the abstract class in the ``Entity`` folder.

Here is an example to how to extend the ``Ticket`` Entity :

```php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Entity\Ticket as BaseTicket;

/**
 * @ORM\Table(name="ticket_tickets")
 * @ORM\Entity(repositoryClass="Maps_red\TicketingBundle\Repository\TicketRepository")
 */
class Ticket extends BaseTicket
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

}
```

you need to configure the listener, which tells the DoctrineBundle about the replacement.

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
            Symfony\Component\Security\Core\User\UserInterface: App\Entity\User
```