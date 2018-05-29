<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 29/05/2018
 * Time: 22:37
 */

namespace Maps_red\TicketingBundle\DependencyInjection;

use Maps_red\TicketingBundle\Form\CreateTicketForm;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class TicketingExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);
        $entities = $config['entities'];
        
        // load bundle's services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $container->getDefinition(CreateTicketForm::class)
            ->setArguments([$entities['ticket_category'], $entities['ticket']]);
    }

}