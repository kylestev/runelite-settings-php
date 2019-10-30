<?php

namespace Kylestev\RuneLite\Settings;

use Kylestev\RuneLite\IntProperty;
use Kylestev\RuneLite\SettingsGroup;

/** @SettingsGroup("deathIndicator") */
class DeathIndicator
{
    /** @IntProperty(key="deathLocationPlane") */
    public $locationPlane;
    /** @IntProperty(key="deathLocationX") */
    public $locationX;
    /** @IntProperty(key="deathLocationY") */
    public $locationY;
    /** @IntProperty(key="deathWorld") */
    public $world;
}
