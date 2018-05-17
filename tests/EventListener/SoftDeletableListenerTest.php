<?php declare(strict_types=1);

namespace Tests\Incompass\SoftDeletableBundle;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\UnitOfWork;
use Incompass\SoftDeletableBundle\EventListener\SoftDeletableListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Argument;
use Doctrine\Common\Collections\Collection;

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
        $entityStub = new EntityStub();
        $this->unitOfWork->getScheduledEntityDeletions()->willReturn([$entityStub]);
        $this->entityManager->persist($entityStub)->shouldBeCalled();

        // We are using Argument::any() here as the datetime is set in the listener
        // and we can't get the exact same DatTime into the test, so the test always fails.
        // argument:any() has to be used in the function call, it can't substitute values inside the argument array
        $this->unitOfWork->propertyChanged($entityStub, 'deletedAt', null, Argument::any())->shouldBeCalled();
        $this->unitOfWork->scheduleExtraUpdate($entityStub, Argument::any())->shouldBeCalled();

        $this->softDeletableListener->onFlush($this->args->reveal());
    }

    /**
     * @test
     */
    public function it_does_not_soft_delete_an_already_soft_deleted_entity(): void
    {
        $entityStub = new EntityStub();
        $this->unitOfWork->getScheduledEntityDeletions()->willReturn([$entityStub]);
        $entityStub->setDeletedAt(new \DateTime());
        $this->entityManager->persist($entityStub)->shouldBeCalled();

        $this->softDeletableListener->onFlush($this->args->reveal());
    }
}
