<?php

namespace Corvus\EventBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateTimeNotPast extends Constraint
{
    public $message = 'The date is in the past.';
}
