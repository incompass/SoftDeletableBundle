<?php

namespace Incompass\SoftDeletableBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Class SoftDeletableFilter
 *
 * @package Incompass\SoftDeletableBundle
 * @author  Joe Mizzi <joe@casechek.com>
 * @author  Mike Bates <mike@casechek.com>
 */
class SoftDeletableFilter extends SQLFilter
{
    /**
     * @var array
     */
    private $disabled = [];

    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (in_array(SoftDeleteTrait::class, class_uses($targetEntity->name))) {
            if (array_key_exists($targetEntity->name, $this->disabled) && $this->disabled[$targetEntity->name] === true) {
                return '';
            } elseif (array_key_exists($targetEntity->rootEntityName, $this->disabled) && $this->disabled[$targetEntity->rootEntityName] === true) {
                return '';
            }
        } else {
            return '';
        }
        return $targetTableAlias . '.deletedAt IS NULL';
    }

    /**
     * @param string $class
     */
    public function disableForEntity(string $class)
    {
        $this->disabled[$class] = true;
    }

    /**
     * @param string $class
     */
    public function enableForEntity(string $class)
    {
        if (!in_array(SoftDeleteTrait::class, class_uses($class))) {
            throw new \InvalidArgumentException();
        } else {
            $this->disabled[$class] = false;
        }
    }
}
