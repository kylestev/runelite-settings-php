<?php

namespace Kylestev\RuneLite\TimeTracking\Farming;

use Kylestev\RuneLite\TimeTracking\Farming\Expression\ExpressionFactory;
use Tightenco\Collect\Support\Collection;

class PatchLoader
{
    /** @var PatchCalculator */
    private $calc;

    /** @var ExpressionFactory */
    private $factory;

    /** @var Collection<Crop> */
    private $produce;

    public function __construct(PatchCalculator $calc, ExpressionFactory $factory, Collection $produce)
    {
        $this->calc = $calc;
        $this->factory = $factory;
        $this->produce = $produce;
    }

    public function load(string $file)
    {
        $contents = file_get_contents($file);
        $decoded = json_decode($contents);
        $contents = null;

        return collect($decoded)
            ->map(function ($x) {
                $cases = collect($x->cases)
                    ->map(function ($y) {
                        return new PatchVarbitCase(
                            $y->state,
                            $this->produce->get($y->produce),
                            $y->varps->start,
                            $y->varps->end,
                            $this->calc->simplify(
                                collect($y->expression)
                                    ->map(function ($z) {
                                        return $this->factory->make($z[0], $z[1]);
                                    })
                                    ->all()
                            ),
                            $this->calc
                        );
                    })->all();
                return new PatchType($this->simplifyEnum($x->name), $cases);
            });
    }

    private function simplifyEnum(string $name): string
    {
        $x = strtolower(str_replace('_', ' ', $name));
        return str_replace(' ', '', ucwords($x));
    }
}
