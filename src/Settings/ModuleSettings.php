<?php

namespace Kylestev\RuneLite\Settings;

abstract class ModuleSettings
{
    abstract function parseSetting(string $key, string $value);

    public function getSettings(array $settings)
    {
        $parsed = [];

        foreach ($settings as $key => $value) {
            $setting = $this->parseSetting($key, $value);
            if ($setting !== null) {
                $parsed[$key] = $setting;
            }
        }

        return $parsed;
    }

    protected function getUsernamePrefixedKey(string $key, int $argsCount)
    {
        $parts = explode('.', $key);

        $username = implode('.', array_slice($parts, 0, count($parts) - $argsCount));

        $args = array_slice($parts, count($parts) - $argsCount);

        return compact('username', 'args');
    }
}
