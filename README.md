TicketingBundle
============
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
![Packagist download](https://img.shields.io/packagist/dt/maps_red/ticketing-bundle.svg)
![GitHub release](https://img.shields.io/github/release/Mapsred/TicketingBundle/all.svg)

## Installation

1. [Setting up the bundle](docs/1-setting_up_the_bundle.md)

Installation
============


### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
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
