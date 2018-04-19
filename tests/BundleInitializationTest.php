<?php

namespace Tests\Incompass\SharedBundle\Queue;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BundleInitializationTest
 *
 * @author  Mike Bates <mike@casechek.com>
 */
class BundleInitializationTest extends WebTestCase
{
    /**
     * @test
     */
    public function it_creates_container(): void
    {
        require_once __DIR__.'/TestKernel.php';
        $kernel = static::createKernel([
            'environment' => 'prod',
            'debug' => false
        ]);
        $kernel->boot();
        $container = $kernel->getContainer();
        $this->assertInstanceOf(ContainerInterface::class, $container);
    }
}