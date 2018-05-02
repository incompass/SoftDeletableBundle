<?php

namespace Incompass\SoftDeletableBundle\Entity;

use DateTime;

/**
 * Interface SoftDeleteInterface
 *
 * @package Incompass\SoftDeletableBundle
 * @author  Joe Mizzi <joe@casehek.com>
 * @author  Mike Bates <mike@casechek.com>
 */
interface SoftDeleteInterface
{
    /**
     * @param DateTime|null $deletedAt
     * @return void
     */
    public function setDeletedAt(DateTime $deletedAt = null);

    /**
     * Returns deletedAt.
     *
     * @return DateTime
     */
    public function getDeletedAt();

    /**
     * @return bool
     */
    public function isDeleted();
}
