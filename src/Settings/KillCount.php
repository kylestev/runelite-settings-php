<?php

namespace Kylestev\RuneLite\Settings;

use Tightenco\Collect\Support\Collection;
use Kylestev\RuneLite\SettingsGroup;

/** @SettingsGroup("killcount") */
class KillCount extends ModuleSettings
{
    public function parseSetting(string $key, string $value)
    {
        $args = $this->getUsernamePrefixedKey($key, 1);
        $killCount = (int) $value;
        $username = $args['username'];
        $bossName = str_replace('\ ', ' ', $args['args'][0]);

        return compact('killCount', 'bossName', 'username');
    }
}
