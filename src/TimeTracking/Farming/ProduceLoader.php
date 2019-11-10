<?php

namespace Kylestev\RuneLite\TimeTracking\Farming;

class ProduceLoader
{
    static function load(string $file)
    {
        $contents = file_get_contents($file);
        $decoded = json_decode($contents);
        $contents = null;

        return collect($decoded)
            ->map(function ($crop) {
                return new Crop(
                    $crop->name,
                    $crop->itemId,
                    $crop->tickrate,
                    $crop->stages,
                    $crop->regrowTickrate ?? 0,
                    $crop->lives ?? 1
                );
            });
    }
}
