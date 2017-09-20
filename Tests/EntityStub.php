<?php

namespace Incompass\SoftDeletableBundle\Tests;

use Incompass\SoftDeletableBundle\SoftDeleteInterface;
use Incompass\SoftDeletableBundle\SoftDeleteTrait;

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
