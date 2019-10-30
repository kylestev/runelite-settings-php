<?php

namespace Kylestev\RuneLite;

use ArrayAccess;
use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

class JavaProperties implements ArrayAccess
{
    private const RUNELITE_CONFIG = 'RuneLite configuration';

    /** @var Collection */
    private $properties;

    /** @var ?Carbon */
    private $generatedAt;

    public function __construct(array $lines)
    {
        $this->properties = collect();
        foreach ($lines as $line) {
            $line = trim($line);
            if (!$line) {
                continue;
            }

            if ($line[0] === '#') {
                $line = trim(substr($line, 1));
                if ($line === self::RUNELITE_CONFIG) {
                    continue;
                }
                try {
                    $this->generatedAt = Carbon::parse($line);
                } catch (\Throwable $th) { }
            } else {
                $eqIndex = strpos($line, '=');
                $key = substr($line, 0, $eqIndex);
                $value = substr($line, $eqIndex + 1);
    
                $this->properties->put($key, $value);
            }
        }
    }

    public function getGeneratedAt(): ?Carbon
    {
        return $this->generatedAt;
    }

    public function diff(JavaProperties $other): Collection
    {
        return $this->properties->diffAssoc($other->properties);
    }

    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function keys(): Collection
    {
        return $this->properties->keys();
    }

    public function offsetGet($key)
    {
        return $this->properties[$key];
    }

    public function offsetSet($key, $value)
    {
        $this->properties[$key] = $value;
    }

    public function offsetUnset($key)
    {
        unset($this->properties[$key]);
    }

    public function offsetExists($key)
    {
        return $this->properties->has($key);
    }
}
