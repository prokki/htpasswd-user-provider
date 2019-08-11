<?php

namespace Htpasswd\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('Htpasswd');

        // @formatter:off
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('path')
                    ->info('The path of the password file generated by `htpasswd` command.')
                    ->example('%kernel.project_dir%/.htpasswd')
                ->end()
                ->arrayNode('roles')
                    ->defaultValue(['ROLE_USER'])
                    ->info('The default roles of the users.')
                    ->example('["ROLE_USER", "ROLE_ADMIN"]')
                    ->prototype('scalar')
                    ->end()
                    ->beforeNormalization()
                        ->castToArray()
                        ->ifNull()
                            ->thenUnset()
                        ->end()
                    ->end()
                ->end()
            ->end();
        // @formatter:on

        return $treeBuilder;
    }
}
