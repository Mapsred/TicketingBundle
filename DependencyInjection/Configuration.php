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
                ->arrayNode("ticket_status")
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('open')
                            ->info('The name of the open status')
                            ->defaultValue('open')
                        ->end()
                        ->scalarNode('closed')
                            ->info('The name of the closed status')
                            ->defaultValue('closed')
                        ->end()
                        ->scalarNode('pending')
                            ->info('The name of the pending status')
                            ->defaultValue('pending')
                        ->end()
                    ->end()
                ->end()
                ->booleanNode('enable_history')
                    ->info('Enable the seen/unseen display for tickets')
                    ->defaultValue(true)
                ->end()
                ->scalarNode('restricted_tickets_role')
                    ->info('Set a role that will have access to the "staff" tickets')
                    ->defaultValue('ROLE_USER')
                ->end()
                ->booleanNode('enable_ticket_restriction')
                    ->info('if true, all new tickets will only be accessible to the owner and the restricted_ticket_role. If false, all new tickets will be public')
                    ->defaultValue(true)
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
                        ->scalarNode('ticket_priority')
                            ->defaultValue('App\Entity\TicketPriority')
                        ->end()
                    ->end()
                ->end()
            ->arrayNode('templates')
            ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('layout')
                        ->defaultValue('@Ticketing/base.html.twig')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('index')
                        ->defaultValue('@Ticketing/ticketing/index.html.twig')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('new')
                        ->defaultValue('@Ticketing/ticketing/new.html.twig')
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('assets')
            ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('stylesheets')
                        ->defaultValue([
                            'bundles/ticketing/vendor/css/bootstrap.min.css',
                            'bundles/ticketing/vendor/css/bootstrap-datepicker3.min.css',
                            'bundles/ticketing/vendor/css/font-awesome.min.css',
                            'bundles/ticketing/vendor/css/select2.min.css',
                            'bundles/ticketing/vendor/css/ionicons.min.css',
                            'bundles/ticketing/vendor/css/dataTables.bootstrap.min.css',
                            'bundles/ticketing/css/AdminLTE.min.css',
                            'bundles/ticketing/css/skin-ticketing.min.css',
                            'bundles/ticketing/css/helper.css',
                        ])->scalarPrototype()->end()
                    ->end()
                    ->arrayNode('javascripts')
                        ->defaultValue([
                            'bundles/ticketing/vendor/js/jquery.min.js',
                            'bundles/ticketing/vendor/js/bootstrap.min.js',
                            'bundles/ticketing/vendor/js/adminlte.min.js',
                            'bundles/ticketing/vendor/js/bootstrap-datepicker.min.js',
                            'bundles/ticketing/vendor/js/bootstrap-datepicker.fr.min.js',
                            'bundles/ticketing/vendor/js/select2.min.js',
                            'bundles/ticketing/vendor/js/select2-fr.min.js',
                            'bundles/ticketing/vendor/js/dataTables.min.js',
                            'bundles/ticketing/vendor/js/dataTables.bootstrap.min.js',
                            'bundles/ticketing/js/script.js',
                        ])->scalarPrototype()->end()
                    ->end()
                ->end()
            ->end()
        ->end()

        ;

        
        return $treeBuilder;
    }
    
}