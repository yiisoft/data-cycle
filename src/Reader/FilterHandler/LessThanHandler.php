<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Reader\Filter\LessThan;

final class LessThanHandler extends CompareHandler
{
    public function getFilterClass(): string
    {
        return LessThan::class;
    }

    protected function getSymbol(): string
    {
        return '<';
    }
}
