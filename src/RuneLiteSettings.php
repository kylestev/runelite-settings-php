<?php

namespace Kylestev\RuneLite;

use Tightenco\Collect\Support\Collection;

class RuneLiteSettings
{
    /** @var JavaProperties */
    private $properties;

    /** @var ?Collection */
    private $grouped = null;

    public function __construct(JavaProperties $properties)
    {
        $this->properties = $properties;
    }

    public function group(string $name): Collection
    {
        return $this->groups()->get($name, collect());
    }

    public function groups(): Collection
    {
        if (is_null($this->grouped)) {
            $this->grouped = $this->properties->getProperties()
                ->groupBy(function ($val, $key) {
                    $dotIndex = strpos($key, '.');
                    $group = substr($key, 0, $dotIndex);
                    return $group;
                }, true)->map(function ($value) {
                    return $value->mapWithKeys(function ($value, $key) {
                        $dotIndex = strpos($key, '.');
                        $ungrouped = substr($key, $dotIndex + 1);
                        return [$ungrouped => $value];
                    });
                });
        }

        return $this->grouped;
    }
}
