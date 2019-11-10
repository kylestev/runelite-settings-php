<?php

namespace Kylestev\RuneLite\TimeTracking\Farming;

use Exception;

class RegionNotFound extends Exception
{
    /** @var int regionId */
    private $regionId;

    public function __construct(int $regionId)
    {
        parent::__construct('Region was not found. regionId = '.$regionId);
    }

    public function getRegionId(): int
    {
        return $this->regionId;
    }
}
