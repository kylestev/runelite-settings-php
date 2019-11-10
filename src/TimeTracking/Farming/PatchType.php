<?php

namespace Kylestev\RuneLite\TimeTracking\Farming;

use Tightenco\Collect\Support\Collection;

class PatchType
{
    public $name;

    /** @var Collection */
    public $cases;

    public function __construct(string $name, array $cases)
    {
        $this->name = $name;
        $this->cases = new Collection($cases);
    }

    public function findCase(int $varbitValue): ?PatchVarbitCase
    {
        /** @var PatchVarbitCase $candidate */
        foreach ($this->cases as $candidate) {
            if ($candidate->inRange($varbitValue)) {
                return $candidate;
            }
        }

        return null;
    }
}
