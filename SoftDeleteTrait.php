<?php

namespace Incompass\SoftDeletableBundle;

use DateTime;

/**
 * Trait SoftDeletable
 * @package Incompass\SoftDeletableBundle
 */
trait SoftDeleteTrait
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $deletedAt;

    /**
     * @param Datetime|null $deletedAt
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
