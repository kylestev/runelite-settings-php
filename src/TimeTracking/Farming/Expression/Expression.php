<?php

namespace Kylestev\RuneLite\TimeTracking\Farming\Expression;

abstract class Expression
{
    /** @var mixed */
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
        if (!$this->validate()) {
            throw new IllegalExpression($this->getType(), $value);
        }
    }

    abstract function getType(): string;

    public function validate(): bool
    {
        return true;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function isType(string $type): bool
    {
        return $this->getType() === $type;
    }

    public function __toString()
    {
        return sprintf(
            'Expression<type=%s, value=%s>',
            $this->getType(),
            $this->getValue()
        );
    }
}
