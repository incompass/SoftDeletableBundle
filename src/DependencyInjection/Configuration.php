<?php declare(strict_types=1);

namespace Incompass\SoftDeletableBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Incompass\SharedBundle\DependencyInjection
 * @author  Joe Mizzi <joe@casechek.com>
 * @author  Mike Bates <mike@casechek.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('soft_deletable_bundle');

        $rootNode
            ->children()
            ->booleanNode('ignore_api_platform_annotations')
            ->defaultTrue()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
