<?php

namespace Kylestev\RuneLite\Settings;

use Kylestev\RuneLite\SettingsGroup;

/** @SettingsGroup("personalbest") */
class PersonalBest extends ModuleSettings
{
    public function parseSetting(string $key, string $value)
    {
        $args = $this->getUsernamePrefixedKey($key, 1);
        $duration = (int) $value;
        $username = $args['username'];
        $bossName = str_replace('\ ', ' ', $args['args'][0]);

        return compact('duration', 'bossName', 'username');
    }
}
