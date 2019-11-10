<?php

namespace Kylestev\RuneLite\TimeTracking\Farming;

use Kylestev\RuneLite\TimeTracking\Farming\Expression\ArithmeticOperatorExpression;
use Kylestev\RuneLite\TimeTracking\Farming\Expression\Expression;
use Kylestev\RuneLite\TimeTracking\Farming\Expression\IntLiteralExpression;
use Kylestev\RuneLite\TimeTracking\Farming\Expression\VarbitExpression;
use RuntimeException;
use Tightenco\Collect\Support\Collection;

class PatchCalculator
{
    public function evaluate(array $expressions, int $varbitValue): int
    {
        // x is the evaluated expression value
        $x = 0;
        $sign = 1;

        /** @var Expression $expr */
        foreach ($expressions as $expr) {
            if ($expr->isType(ArithmeticOperatorExpression::class)) {
                $sign = $expr->getValue();
            } else {
                if ($expr->isType(VarbitExpression::class)) {
                    if ($varbitValue === -43594) {
                        throw new RuntimeException('Whoopsies!');
                    }
                    $val = $varbitValue;
                } else {
                    $val = $expr->getValue();
                }
                $x += ($sign * $val);
                $sign = 1;
            }
        }

        return $x;
    }

    public function simplify(array $expressions)
    {
        $exprs = new Collection($expressions);
        if ($exprs->count() >= 3) {
            $exprs = $this->reduceConstantExpressions($expressions);
        }
        if ($exprs->filter(function ($x) { return $x->isType(VarbitExpression::class); })->isEmpty()) {
            $evald = $this->evaluate($exprs->toArray(), -43594);
            return new Collection([
                new IntLiteralExpression($evald)
            ]);
        }
        $intExprs = $exprs->filter(function ($x) {
            return $x->isType(IntLiteralExpression::class);
        })->count();
        if ($intExprs > 1) {
            // for ($i=1; $i < $exprs->count() - 1; $i++) { 
            //     $expr = $exprs[$i];
            //     $expr2 = $exprs[$i + 1];

            //     if (!$expr->isType(ArithmeticOperatorExpression::class)) {
            //         continue;
            //     }

            //     if ($expr->getValue() !== -1) {
            //         continue;
            //     }

            //     if (!$expr2->isType(IntLiteralExpression::class)) {
            //         continue;
            //     }

            //     $exprs[$i] = new ArithmeticOperatorExpression('+');
            //     $exprs[$i + 1] = new IntLiteralExpression(
            //         $expr->getValue() * $expr2->getValue()
            //     );
            // }

            if ($exprs->first()->isType(IntLiteralExpression::class)) {
                $secondToLast = $exprs->get($exprs->count() - 2);
                if ($secondToLast->isType(ArithmeticOperatorExpression::class)
                    && $exprs->last()->isType(IntLiteralExpression::class)) {

                    // $first = $exprs->shift();
                    // $val = $exprs->pop();
                    // $op = $exprs->pop();

                    // dump($first, $val, $op);

                    // $newExpr = new IntLiteralExpression(
                    //     $first->getValue() + ($op->getValue() * $val->getValue())
                    // );

                    echo PHP_EOL;

                    // dd($newExpr, $exprs);

                    // collect([$newExpr])->concat($exprs)->dump();

                    // $exprs = $exprs->slice(0, $exprs->count() - 2);
                    // $exprs[0] = $newExpr;
                }
            }
        }
        return $exprs;
    }

    private function reduceConstantExpressions(array $expressions): Collection
    {
        $exprs = new Collection();
        $numExpressions = count($expressions);
        if ($numExpressions >= 3) {
            $i = 0;
            while ($i < $numExpressions - 2) {
                $firstExpr = $expressions[$i];
                if ($expressions[$i]->getType() === IntLiteralExpression::class) {
                    $opExpr = $expressions[$i + 1];
                    $otherExpr = $expressions[$i + 2];
                    if ($firstExpr->getType() === $otherExpr->getType()) {
                        if ($opExpr->isType(ArithmeticOperatorExpression::class)) {
                            $sign = $opExpr->getValue();
                            $exprs->push(new IntLiteralExpression(
                                $firstExpr->getValue() + ($sign * $otherExpr->getValue())
                            ));
                            $i += 3;
                            continue;
                        }
                    }
                }
                $exprs->push($firstExpr);
                $i++;
            }
            return $exprs->concat(array_slice($expressions, $numExpressions - 2));
        }
    }
}
