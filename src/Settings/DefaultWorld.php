<?php

namespace Kylestev\RuneLite\Settings;

use Kylestev\RuneLite\IntProperty;
use Kylestev\RuneLite\SettingsGroup;

/** @SettingsGroup("defaultworld") */
class DefaultWorld
{
    /** @IntProperty(key="defaultWorld") */
    public $world;
}
