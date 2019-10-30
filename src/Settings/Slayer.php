<?php

namespace Kylestev\RuneLite\Settings;

use Kylestev\RuneLite\IntProperty;
use Kylestev\RuneLite\SettingsGroup;
use Kylestev\RuneLite\StringProperty;

/** @SettingsGroup("slayer") */
class Slayer
{
    /** @IntProperty */
    public $points;

    /** @IntProperty */
    public $initialAmount;

    /** @IntProperty */
    public $amount;

    /** @IntProperty */
    public $streak;

    /** @StringProperty(key="taskName") */
    public $taskName;

    /** @IntProperty(key="expeditious") */
    public $expeditiousCharges;

    /** @IntProperty(key="slaughter") */
    public $slaughterCharges;
}
