<?php

namespace Kylestev\RuneLite\TimeTracking\Farming\Expression;

use Exception;

class IllegalExpression extends Exception
{
    public function __construct(string $expression, $value)
    {
        parent::__construct(sprintf(
            'Illegal expression (type=%s, value=%s)',
            $expression,
            $value
        ));
    }
}
