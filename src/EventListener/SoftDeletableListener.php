<?php

namespace Incompass\SoftDeletableBundle\EventListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Incompass\TimestampableBundle\Entity\SoftDeleteInterface;
use Incompass\TimestampableBundle\Entity\SoftDeleteTrait;

/**
 * Class SoftDeletableListener
 *
 * @package Incompass\SoftDeletableBundle\EventListener
 * @author  Joe Mizzi <joe@casechek.com>
 * @author  Mike Bates <mike@casechek.com>
 */
class SoftDeletableListener
{
    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {

        $uow = $args->getEntityManager()->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $insert) {
            if ($insert instanceof TimestampInterface) {
                $timestamp = true;
            }
        }

        foreach ($uow->getScheduledEntityInsertions() as $insert) {
            if ($insert instanceof SoftDeleteInterface) {
                $delete = true;
            }
        }

        $entityManager = $args->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
            if ($entity instanceof SoftDeleteInterface) {
                /** @var SoftDeleteTrait $entity */
                if ($entity->isDeleted()) {
                    continue;
                }
                $entity->setDeletedAt(new DateTime());
                $entityManager->persist($entity);
                $unitOfWork->propertyChanged($entity, 'deletedAt', null, $entity->getDeletedAt());
                $unitOfWork->scheduleExtraUpdate($entity, [
                    'deletedAt' => [null, $entity->getDeletedAt()]
                ]);
            } elseif ($entity instanceof SoftDeleteInterface) {
                $pause = 1;
            }
        }
    }
}
