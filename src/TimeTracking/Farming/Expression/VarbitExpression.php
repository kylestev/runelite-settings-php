<?php

namespace Kylestev\RuneLite\TimeTracking\Farming\Expression;

class VarbitExpression extends Expression
{
    public function __construct($value)
    {
        parent::__construct($value);
    }

    public function getType(): string
    {
        return self::class;
    }
}
