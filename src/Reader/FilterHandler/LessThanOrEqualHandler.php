<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Reader\Filter\LessThanOrEqual;

final class LessThanOrEqualHandler extends CompareHandler
{
    public function getOperator(): string
    {
        return LessThanOrEqual::getOperator();
    }

    protected function getSymbol(): string
    {
        return '<=';
    }
}
