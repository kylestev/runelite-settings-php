<?php

namespace Kylestev\RuneLite\TimeTracking\Farming;

use Exception;

class FarmingPatchNotFound extends Exception
{
    /** @var int */
    private $regionId;

    /** @var int */
    private $patchVar;

    public function __construct(int $regionId, int $patchVar)
    {
        $message = sprintf('(regionId = %d, patchVar = %d)', $regionId, $patchVar);
        parent::__construct($message);
    }

    public function getRegionId(): int
    {
        return $this->regionId;
    }

    public function getPatchVar(): int
    {
        return $this->patchVar;
    }
}
