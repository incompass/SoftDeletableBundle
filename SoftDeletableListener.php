<?php

namespace Incompass\SoftDeletableBundle;

use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;

/**
 * Class SoftDeletableListener
 *
 * @package Incompass\SoftDeletableBundle
 * @author  Joe Mizzi <joe@casechek.com>
 * @author  Mike Bates <mike@casechek.com>
 */
class SoftDeletableListener implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'onFlush',
        ];
    }

    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
            if (in_array(SoftDeleteTrait::class, class_uses($entity))) {
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
            }
        }
    }
}
