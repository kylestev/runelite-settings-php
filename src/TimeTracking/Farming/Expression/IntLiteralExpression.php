<?php

namespace Kylestev\RuneLite\TimeTracking\Farming\Expression;

class IntLiteralExpression extends Expression
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }

    public function validate(): bool
    {
        return is_int($this->value);
    }

    public function getType(): string
    {
        return self::class;
    }
}
