<?php

namespace Kylestev\RuneLite\TimeTracking\Farming;

use Tightenco\Collect\Support\Collection;

class PatchVarbitCase
{
    /** @var string */
    public $state;

    /** @var Crop */
    public $crop;

    /** @var int */
    private $rangeStart;

    /** @var int */
    private $rangeEnd;

    /** @var Collection<Expression> */
    public $expressions;

    /** @var PatchCalculator */
    private $calc;

    public function __construct(
        string $state,
        Crop $crop,
        int $rangeStart,
        int $rangeEnd,
        $expressions,
        PatchCalculator $calc
    )
    {
        $this->state = $state;
        $this->crop = $crop;
        $this->rangeStart = $rangeStart;
        $this->rangeEnd = $rangeEnd;
        $this->expressions = new Collection($expressions);
        $this->calc = $calc;
    }

    public function inRange(int $value)
    {
        return ($this->rangeStart <= $value) && ($value <= $this->rangeEnd);
    }

    public function eval($varbitValue)
    {
        return $this->calc->evaluate($this->expressions->all(), $varbitValue);
    }
}
