<?php

namespace Kylestev\RuneLite\TimeTracking\Farming\Expression;

use Tightenco\Collect\Support\Collection;
use Kylestev\RuneLite\TimeTracking\Farming\Crop;
use Kylestev\RuneLite\TimeTracking\Farming\ExpressionTypes;

class ExpressionFactory
{
    /** @var Collection<Crop> */
    private $produce;

    public function __construct(Collection $produce)
    {
        $this->produce = $produce;
    }

    public function make(string $typeTag, $value = null)
    {
        switch ($typeTag) {
            case ExpressionTypes::IntegerLiteral:
                return new IntLiteralExpression($value);
            case ExpressionTypes::ArithmeticOp:
                return new ArithmeticOperatorExpression($value);
            case ExpressionTypes::VarbitRef:
                return new VarbitExpression($value);
            case ExpressionTypes::ProduceRef:
                /** @var Crop $crop */
                $crop = $this->produce->get($value);
                if ($crop === null) throw new IllegalExpression($typeTag, $value);
                return new IntLiteralExpression($crop->stages);
            default:
                throw new IllegalExpression($typeTag, $value);
        }
    }
}
