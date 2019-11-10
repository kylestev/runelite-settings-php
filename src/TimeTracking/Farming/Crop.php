<?php

namespace Kylestev\RuneLite\TimeTracking\Farming;

class Crop
{
    /** @var string */
    public $name;

    /** @var int */
    public $itemId;

    /** @var int */
    public $tickrate;

    /** @var int */
    public $stages;

    /** @var int */
    public $regrowTickrate;

    /** @var int */
    public $lives;

    public function __construct(
        string $name,
        int $itemId,
        int $tickrate,
        int $stages,
        int $regrowTickrate,
        int $lives
    )
    {
        $this->name = $name;
        $this->itemId = $itemId;
        $this->tickrate = $tickrate;
        $this->stages = $stages;
        $this->regrowTickrate = $regrowTickrate;
        $this->lives = $lives;
    }
}

