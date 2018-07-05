Step 1 - Setting up the Bundle
======================

### A - Enable the Bundle

If you use Symfony 3.x enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Maps_red\TicketingBundle\TicketingBundle(),
        );

        // ...
    }

    // ...
}
```

If you use Symfony 4.x you don't need the previous step, thanks to Symfony Flex

### B - Import the routing

Import the ``routes.yaml`` routing file into your own routes file.

```yaml
# app/config/routes.yaml
  ticketing_routing:
    resource: '@TicketingBundle/Resources/config/routing/routes.yaml' 
```

### Continue to the next step
[Step 2 - Setting up the entities](2-setting_up_the_entities.md)