<?php

namespace Incompass\SoftDeletableBundle\EventListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Incompass\SoftDeletableBundle\Entity\SoftDeleteInterface;
use Incompass\SoftDeletableBundle\Entity\SoftDeleteTrait;

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
        $entityManager = $args->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
            if ($entity instanceof SoftDeleteInterface) {
                $oldValue = null;
                /** @var SoftDeleteTrait $entity */
                if ($entity->isDeleted()) {
                    $oldValue = $entity->getDeletedAt();
                } else {
                    $entity->setDeletedAt(new \DateTime());
                }

                $unitOfWork->propertyChanged($entity, 'deletedAt', $oldValue, $entity->getDeletedAt());
                $unitOfWork->scheduleExtraUpdate($entity, [
                    'deletedAt' => [$oldValue, $entity->getDeletedAt()]
                ]);
            }
        }
    }
}
