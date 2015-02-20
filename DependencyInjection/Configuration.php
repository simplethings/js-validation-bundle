<?php

namespace SimpleThings\JsValidationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * @author David Badura <badura@simplethings.de>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        return $builder->root('simple_things_js_validation')
            ->children()
                ->arrayNode('objects')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ->end();
    }
}
