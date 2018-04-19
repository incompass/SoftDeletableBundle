<?php

namespace Incompass\SoftDeletableBundle\DependencyInjection;

use Incompass\SoftDeletableBundle\EntityListener\SoftDeletableListener;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class SharedExtension
 *
 * @package Incompass\SharedBundle\DependencyInjection
 * @author  Joe Mizzi <joe@casechek.com>
 */
class SharedExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\BadMethodCallException
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $definition = new Definition(SoftDeletableListener::class);
        $definition->addTag('doctrine.event_listener', ['event' => 'onFlush', 'priority' => -9999]);
        $container->setDefinition('soft_deletable.listener', $definition);
    }
}
