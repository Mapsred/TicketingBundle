<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 29/05/2018
 * Time: 22:37
 */

namespace Maps_red\TicketingBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class TicketingExtension
 * @package Maps_red\TicketingBundle\DependencyInjection
 */
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
        $container->setParameter('ticketing.enable_history', $config['enable_history']);

        // load bundle's services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $this->addFormArguments($container, $entities);

        // Manage Ticketing Managers
        $this->addManagerArguments($container, $config, $entities);
    }

    /**
     * @param ContainerBuilder $container
     * @param array $config
     * @param array $entities
     */
    public function addManagerArguments(ContainerBuilder $container, array $config, array $entities)
    {
        $managers = $container->findTaggedServiceIds('ticketing.manager');
        foreach ($managers as $id => $attributes) {
            $definition = $container->getDefinition($id);
            foreach ($attributes[0] as $name => $parameter) {
                if ($name === 'class') {
                    $definition->setAutowired(true)->setArgument(1, $entities[$parameter]);
                } elseif (isset($config[$name])) {
                    $definition->addArgument($config[$name]);
                }
            }
        }

    }

    /**
     * @param ContainerBuilder $container
     * @param array $entities
     */
    protected function addFormArguments(ContainerBuilder $container, array $entities)
    {
        $container->getDefinition('Maps_red\TicketingBundle\Form\CreateTicketForm')
            ->setArguments([$entities['ticket_category'], $entities['ticket']]);

        $container->getDefinition('Maps_red\TicketingBundle\Form\TicketForm')
            ->setArguments([$entities['ticket']]);
    }

}