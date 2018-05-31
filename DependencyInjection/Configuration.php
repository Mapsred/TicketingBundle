<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 29/05/2018
 * Time: 23:13
 */

namespace Maps_red\TicketingBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ticketing');
        $rootNode
            ->children()
                ->scalarNode('default_status_name')
                    ->info('The name of the default status')
                    ->defaultValue('open')
                ->end()
                ->arrayNode("entities")
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('ticket')
                            ->defaultValue('App\Entity\Ticket')
                        ->end()
                        ->scalarNode('ticket_category')
                            ->defaultValue('App\Entity\TicketCategory')
                        ->end()
                        ->scalarNode('ticket_comment')
                            ->defaultValue('App\Entity\TicketComment')
                        ->end()
                        ->scalarNode('ticket_history')
                            ->defaultValue('App\Entity\TicketHistory')
                        ->end()
                        ->scalarNode('ticket_keyword')
                             ->defaultValue('App\Entity\TicketKeyword')
                        ->end()
                        ->scalarNode('ticket_status')
                            ->defaultValue('App\Entity\TicketStatus')
                        ->end()
                    ->end();

        
        return $treeBuilder;
    }
    
}