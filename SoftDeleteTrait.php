<?php

namespace Incompass\SoftDeletableBundle;

use DateTime;
use Doctrine\ORM\Mapping\Column;

/**
 * Trait SoftDeletable
 *
 * @package Incompass\SoftDeletableBundle
 * @author  Joe Mizzi <joe@casechek.com>
 */
trait SoftDeleteTrait
{
    /**
     * @Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $deletedAt;

    /**
     * @param DateTime|null $deletedAt
     * @return void
     */
    public function setDeletedAt(DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * Returns deletedAt.
     *
     * @return DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return null !== $this->deletedAt;
    }
}
