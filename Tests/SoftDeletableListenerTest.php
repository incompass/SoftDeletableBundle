<?php

namespace Incompass\SoftDeletableBundle\Tests;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\UnitOfWork;
use Incompass\SoftDeletableBundle\SoftDeletableListener;
use PHPUnit_Framework_TestCase;

/**
 * Class SoftDeletableListenerTest
 *
 * @package Incompass\SoftDeletableBundle\Tests
 * @author  Joe Mizzi <joe@casechek.com>
 * @author  Mike Bates <mike@casechek.com>
 */
class SoftDeletableListenerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_soft_deletes_an_entity()
    {
        $entityStub = new EntityStub();

        $unitOfWorkMock = \Mockery::mock(UnitOfWork::class);
        $unitOfWorkMock
            ->shouldReceive('getScheduledEntityDeletions')
            ->andReturn([$entityStub]);
        $unitOfWorkMock
            ->shouldReceive('propertyChanged')
            ->once()
            ->withAnyArgs();
        $unitOfWorkMock
            ->shouldReceive('scheduleExtraUpdate')
            ->once()
            ->withAnyArgs();

        $entityManagerMock = \Mockery::mock(EntityManager::class);
        $entityManagerMock
            ->shouldReceive('getUnitOfWork')
            ->andReturn($unitOfWorkMock);
        $entityManagerMock
            ->shouldReceive('persist')
            ->once()
            ->with($entityStub);

        $argsMock = \Mockery::mock(OnFlushEventArgs::class);
        $argsMock
            ->shouldReceive('getEntityManager')
            ->andReturn($entityManagerMock);

        $softDeletableListener = new SoftDeletableListener();
        $softDeletableListener->onFlush($argsMock);
        $this->assertTrue($entityStub->isDeleted());
    }

    /**
     * @test
     */
    public function it_does_not_soft_delete_an_already_soft_deleted_entity()
    {
        $entityStub = new EntityStub();
        $entityStub->setDeletedAt(new DateTime());

        $unitOfWorkMock = \Mockery::mock(UnitOfWork::class);
        $unitOfWorkMock
            ->shouldReceive('getScheduledEntityDeletions')
            ->andReturn([$entityStub]);

        $entityManagerMock = \Mockery::mock(EntityManager::class);
        $entityManagerMock
            ->shouldReceive('getUnitOfWork')
            ->andReturn($unitOfWorkMock);
        $entityManagerMock
            ->shouldNotHaveReceived('persist');

        $argsMock = \Mockery::mock(OnFlushEventArgs::class);
        $argsMock
            ->shouldReceive('getEntityManager')
            ->andReturn($entityManagerMock);

        $softDeletableListener = new SoftDeletableListener();
        $softDeletableListener->onFlush($argsMock);
    }
}
