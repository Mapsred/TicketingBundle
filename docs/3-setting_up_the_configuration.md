Step 3 - Setting up the configuration
=====================================

### A - Default configuration

```yaml
# app/config/packages/ticketing.yaml
ticketing:
    ticket_status:

        # The name of the open status
        open:                 open

        # The name of the closed status
        closed:               closed

        # The name of the pending status
        pending:              pending

        # The name of the waiting status
        waiting:              waiting

    # Enable the seen/unseen display for tickets
    enable_history:       true

    # Set a role that will have access to the "staff" tickets
    restricted_tickets_role: ROLE_USER

    # if true, all new tickets will only be accessible to the owner and the restricted_ticket_role. If false, all new tickets will be public
    enable_ticket_restriction: true
    entities:
        ticket:               App\Entity\Ticket
        ticket_category:      App\Entity\TicketCategory
        ticket_comment:       App\Entity\TicketComment
        ticket_history:       App\Entity\TicketHistory
        ticket_keyword:       App\Entity\TicketKeyword
        ticket_status:        App\Entity\TicketStatus
        ticket_priority:      App\Entity\TicketPriority
        ticket_status_history: App\Entity\TicketStatusHistory
    templates:
        list:                 '@Ticketing/ticketing/list.html.twig'
        layout:               '@Ticketing/base.html.twig'
        perso:                '@Ticketing/ticketing/perso.html.twig'
        new:                  '@Ticketing/ticketing/new.html.twig'
        detail:               '@Ticketing/ticketing/detail.html.twig'
        rating_rating:        '@Ticketing/ticketing/rating/rating.html.twig'
        rating_closed:        '@Ticketing/ticketing/rating/closed.html.twig'
    assets:
        stylesheets:

            # Defaults:
            - bundles/ticketing/vendor/css/bootstrap.min.css
            - bundles/ticketing/vendor/css/bootstrap-datepicker3.min.css
            - bundles/ticketing/vendor/css/font-awesome.min.css
            - bundles/ticketing/vendor/css/select2.min.css
            - bundles/ticketing/vendor/css/ionicons.min.css
            - bundles/ticketing/vendor/css/dataTables.bootstrap.min.css
            - bundles/ticketing/vendor/css/star-rating.min.css
            - bundles/ticketing/vendor/css/star-rating-theme.min.css
            - bundles/ticketing/css/AdminLTE.min.css
            - bundles/ticketing/css/skin-ticketing.min.css
            - bundles/ticketing/css/helper.css
        javascripts:

            # Defaults:
            - bundles/ticketing/vendor/js/jquery.min.js
            - bundles/ticketing/vendor/js/bootstrap.min.js
            - bundles/ticketing/vendor/js/adminlte.min.js
            - bundles/ticketing/vendor/js/bootstrap-datepicker.min.js
            - bundles/ticketing/vendor/js/bootstrap-datepicker.fr.min.js
            - bundles/ticketing/vendor/js/select2.min.js
            - bundles/ticketing/vendor/js/select2-fr.min.js
            - bundles/ticketing/vendor/js/dataTables.min.js
            - bundles/ticketing/vendor/js/dataTables.bootstrap.min.js
            - bundles/ticketing/vendor/js/star-rating.min.js
            - bundles/ticketing/js/script.js
```

### B - Parameters explaination

All parameters are optional if you use the bundle the basic way.

But if you need, you can override the default configuration using the the full configuration above.

* ``ticket_status.open`` : All new created tickets (``Maps_red\TicketingBundle\Model\TicketInteface``) will have a
status (``Maps_red\TicketingBundle\Model\TicketStatusInterface``). This status will be found by its name with this parameter.
* ``ticket_status.closed`` : All closed tickets (``Maps_red\TicketingBundle\Model\TicketInteface``) will have a
status (``Maps_red\TicketingBundle\Model\TicketStatusInterface``). This status will be found by its name with this parameter.
The default configuration recommends you to create a status with ``open`` as name.
* ``enable_history`` : If enabled, all users will have a status of seen/unseen on their tickets. 
They can also check if there is a change on it.
* ``enable_ticket_restriction`` : If the parameter is to true, all the new tickets will be restricted to user with the 
role defined in the ``restricted_tickets_roles`` parameter. Otherwise all tickets will have the ``public`` tag and will 
be accessible for all users.
* ``restricted_tickets_roles`` :  # Set a role that will have access to the restricted tickets. Only useful if the 
``enable_ticket_restriction`` parameter is to true.
* ``entities`` : A list of all the TicketingBundle Entities. It will be used in the bundle to work properly with your 
self-created class.
* ``templates`` : A list of all the templates used by the bundle. It is not recommended to override this parameter but 
you could do it to easily override the default layout as example.  
* ``stylesheets`` : All the stylesheets used by the bundle. It is not recommended to override this parameter because
it might break some styling.
* ``javascripts`` : All the javascripts used by the bundle. It is not recommended to override this parameter because
it might break some code.


###C - Fixture

Move the folder DataFixtures of the bundle to your project at src/
run the command :

```
$ php bin/console doctrine:fixtures:load
```

[return to the index](../README.md)