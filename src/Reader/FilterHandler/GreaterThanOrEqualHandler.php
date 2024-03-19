<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Reader\Filter\GreaterThanOrEqual;

final class GreaterThanOrEqualHandler extends CompareHandler
{
    public function getFilterClass(): string
    {
        return GreaterThanOrEqual::class;
    }

    protected function getSymbol(): string
    {
        return '>=';
    }
}
