<?php

namespace Kylestev\RuneLite\TimeTracking\Farming;

use Tightenco\Collect\Support\Collection;

class FarmingWorld
{
    /** @var Collection<Crop> */
    private $produce;
    /** @var Collection */
    private $patches;

    private $regions;

    public function __construct(
        Collection $produce,
        Collection $patches
    )
    {
        $this->produce = $produce;
        $this->patches = $patches;
        $this->regions = new Collection();
    }

    public function addRegion(int $regionId, string $name, $patches)
    {
        $this->regions->put($regionId, compact('regionId', 'name', 'patches'));
    }

    /**
     * @throws FarmingPatchNotFound
     * @throws RegionNotFound
     */
    public function findPatch(int $regionId, int $varIndex)
    {
        if (!$this->regions->has($regionId)) {
            throw new RegionNotFound($regionId);
        }

        $region = $this->regions[$regionId];
        $regionPatch = (new Collection($region['patches']))->firstWhere('varIndex', $varIndex);
        if (is_null($regionPatch)) {
            throw new FarmingPatchNotFound($regionId, $varIndex);
        }

        return $this->patches->firstWhere('name', $regionPatch->patchType);
    }
}
