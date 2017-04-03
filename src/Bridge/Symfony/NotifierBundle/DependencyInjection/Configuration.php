<?php

/*
 * This file is part of notifier component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Bundle\NotifierBundle\DependencyInjection;

use Staccato\Component\Notifier\Message\Message;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('staccato_notifier');

        $this->addMessageTypesSection($rootNode);
        $this->addServiceSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('notifier_manager')->defaultValue('staccato_notifier.notifier_manager.default')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addMessageTypesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('message_types')
                    ->prototype('array')
                         ->children()
                             ->scalarNode('class')->defaultValue(Message::class)->end()
                             ->scalarNode('transport')
                                 ->isRequired()
                                 ->cannotBeEmpty()
                             ->end()
                         ->end()
                     ->end()
                ->end()
            ->end();
    }
}
