<?php
// src/AppBundle/Validator/Constraints/ContainsAlphanumericValidator.php
namespace Corvus\EventBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateTimeNotPastValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (new \DateTime() < $value) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}
