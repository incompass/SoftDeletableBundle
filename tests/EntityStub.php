<?php

namespace Tests\Incompass\SoftDeletableBundle;

use Incompass\SoftDeletableBundle\Entity\SoftDeleteInterface;
use Incompass\SoftDeletableBundle\Entity\SoftDeleteTrait;

/**
 * Class EntityStub
 *
 * @package Incompass\SoftDeletableBundle
 * @author  Joe Mizzi <joe@casechek.com>
 * @author  Mike Bates <mike@casechek.com>
 */
class EntityStub implements SoftDeleteInterface
{
    use SoftDeleteTrait;
}
