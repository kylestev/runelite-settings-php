<?php

namespace Kylestev\RuneLite\Settings;

use Carbon\Carbon;
use Kylestev\RuneLite\SettingsGroup;

/** @SettingsGroup("timetracking") */
class TimeTracking extends ModuleSettings
{
    public function parseSetting(string $key, string $value)
    {
        $varbitSettings = $this->getVarbitSetting($value);

        if ($varbitSettings === null) {
            return null;
        }

        $parsedKey = $this->getUsernamePrefixedKey($key, $numArgs = 2);

        $username = $parsedKey['username'];
        $args = $parsedKey['args'];

        $tracker = [];

        if ($args[0] === 'birdhouse') {
            $tracker['houseVarp'] = (int) $args[1];
            $tracker['type'] = 'birdhouse';
        } else {
            $tracker['regionId'] = (int) $args[0];
            $tracker['patchVar'] = (int) $args[1];
            $tracker['type'] = 'farming';
        }

        return array_merge(
            compact('username'),
            $tracker,
            $varbitSettings
        );
    }

    private function getVarbitSetting(string $value)
    {
        if (strpos($value, '\\:') !== false) {
            $parts = explode('\\:', $value, 2);
            $varbitValue = (int) $parts[0];
            $timestamp = Carbon::createFromTimestampUTC((int) $parts[1]);
            return compact('varbitValue', 'timestamp');
        }

        return null;
    }
}
