<?php

namespace Kylestev\RuneLite\TimeTracking\Farming\Expression;

class ArithmeticOperatorExpression extends Expression
{
    public const PLUS_OP = '+';
    public const MINUS_OP = '-';

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function validate(): bool
    {
        return $this->value === self::PLUS_OP || $this->value === self::MINUS_OP;
    }

    public function getValue()
    {
        if ($this->value === self::MINUS_OP) {
            return -1;
        }

        return 1;
    }

    public function getType(): string
    {
        return self::class;
    }
}
