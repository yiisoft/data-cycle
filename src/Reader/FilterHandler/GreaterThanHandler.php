<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Reader\Filter\GreaterThan;

final class GreaterThanHandler extends CompareHandler
{
    public function getFilterClass(): string
    {
        return GreaterThan::class;
    }

    protected function getSymbol(): string
    {
        return '>';
    }
}
