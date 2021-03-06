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
                /** @var SoftDeleteTrait $entity */
                if ($entity->isDeleted()) {
                    $entityManager->persist($entity);
                    continue;
                }
                $entity->setDeletedAt(new \DateTime());
                $entityManager->persist($entity);

                $unitOfWork->propertyChanged($entity, 'deletedAt', null, $entity->getDeletedAt());
                $unitOfWork->scheduleExtraUpdate($entity, [
                    'deletedAt' => [null, $entity->getDeletedAt()]
                ]);
            }
        }
    }
}
