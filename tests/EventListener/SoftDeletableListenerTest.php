<?php declare(strict_types=1);

namespace Tests\Incompass\SoftDeletableBundle;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\UnitOfWork;
use Incompass\SoftDeletableBundle\EventListener\SoftDeletableListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Class SoftDeletableListenerTest
 *
 * @package Incompass\SoftDeletableBundle\Tests
 * @author  Joe Mizzi <joe@casechek.com>
 * @author  Mike Bates <mike@casechek.com>
 */
class SoftDeletableListenerTest extends TestCase
{
    /**
     * @var OnFlushEventArgs|ObjectProphecy
     */
    private $args;

    /**
     * @var UnitOfWork|ObjectProphecy
     */
    private $unitOfWork;

    /**
     * @var EntityManager|ObjectProphecy
     */
    private $entityManager;

    /**
     * @var SoftDeletableListener;
     */
    private $softDeletableListener;

    /**
     *
     */
    public function setUp()
    {
        $this->args = $this->prophesize(OnFlushEventArgs::class);
        $this->unitOfWork = $this->prophesize(UnitOfWork::class);
        $this->entityManager = $this->prophesize(EntityManager::class);
        $this->args->getEntityManager()->willReturn($this->entityManager);
        $this->entityManager->getUnitOfWork()->willReturn($this->unitOfWork);
        $this->softDeletableListener = new SoftDeletableListener();
    }

    /**
     * @test
     */
    public function it_soft_deletes_an_entity(): void
    {
        $this->softDeletableListener->onFlush($this->args->reveal());
    }


    /**
     * @test
     */
//    public function it_soft_deletes_an_entity(): void
//    {
//        $entityStub = new EntityStub();
//
//        $unitOfWorkMock = \Mockery::mock(UnitOfWork::class);
//        $unitOfWorkMock
//            ->shouldReceive('getScheduledEntityDeletions')
//            ->andReturn([$entityStub]);
//        $unitOfWorkMock
//            ->shouldReceive('propertyChanged')
//            ->once()
//            ->withAnyArgs();
//        $unitOfWorkMock
//            ->shouldReceive('scheduleExtraUpdate')
//            ->once()
//            ->withAnyArgs();
//
//        $entityManagerMock = \Mockery::mock(EntityManager::class);
//        $entityManagerMock
//            ->shouldReceive('getUnitOfWork')
//            ->andReturn($unitOfWorkMock);
//        $entityManagerMock
//            ->shouldReceive('persist')
//            ->once()
//            ->with($entityStub);
//
//        $argsMock = \Mockery::mock(OnFlushEventArgs::class);
//        $argsMock
//            ->shouldReceive('getEntityManager')
//            ->andReturn($entityManagerMock);
//
//        $softDeletableListener = new SoftDeletableListener();
//        $softDeletableListener->onFlush($argsMock);
//        $this->assertTrue($entityStub->isDeleted());
//    }

    /**
     * @test
     */
//    public function it_does_not_soft_delete_an_already_soft_deleted_entity(): void
//    {
//        $entityStub = new EntityStub();
//        $entityStub->setDeletedAt(new DateTime());
//
//        $unitOfWorkMock = \Mockery::mock(UnitOfWork::class);
//        $unitOfWorkMock
//            ->shouldReceive('getScheduledEntityDeletions')
//            ->andReturn([$entityStub]);
//
//        $entityManagerMock = \Mockery::mock(EntityManager::class);
//        $entityManagerMock
//            ->shouldReceive('getUnitOfWork')
//            ->andReturn($unitOfWorkMock);
//        $entityManagerMock
//            ->shouldNotHaveReceived('persist');
//
//        $argsMock = \Mockery::mock(OnFlushEventArgs::class);
//        $argsMock
//            ->shouldReceive('getEntityManager')
//            ->andReturn($entityManagerMock);
//
//        $softDeletableListener = new SoftDeletableListener();
//        $softDeletableListener->onFlush($argsMock);
//    }
}
