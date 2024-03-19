<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Reader\Filter\LessThanOrEqual;

final class LessThanOrEqualHandler extends CompareHandler
{
    public function getFilterClass(): string
    {
        return LessThanOrEqual::class;
    }

    protected function getSymbol(): string
    {
        return '<=';
    }
}
