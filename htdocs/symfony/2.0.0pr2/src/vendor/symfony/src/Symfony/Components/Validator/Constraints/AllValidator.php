<?php

namespace Symfony\Components\Validator\Constraints;

use Symfony\Components\Validator\Constraint;
use Symfony\Components\Validator\ConstraintValidator;
use Symfony\Components\Validator\Exception\UnexpectedTypeException;

class AllValidator extends ConstraintValidator
{
    public function isValid($value, Constraint $constraint)
    {
        if ($value === null) {
            return true;
        }

        if (!is_array($value) && !$value instanceof \Traversable) {
            throw new UnexpectedTypeException($value, 'array or Traversable');
        }

        $walker = $this->context->getGraphWalker();
        $group = $this->context->getGroup();
        $propertyPath = $this->context->getPropertyPath();

        // cannot simply cast to array, because then the object is converted to an
        // array instead of wrapped inside
        $constraints = is_array($constraint->constraints) ? $constraint->constraints : array($constraint->constraints);

        foreach ($value as $key => $element) {
            foreach ($constraints as $constr) {
                $walker->walkConstraint($constr, $element, $group, $propertyPath.'['.$key.']');
            }
        }

        return true;
    }
}