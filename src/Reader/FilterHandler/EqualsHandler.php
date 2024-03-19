<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Reader\Filter\Equals;

final class EqualsHandler extends CompareHandler
{
    public function getFilterClass(): string
    {
        return Equals::class;
    }

    protected function getSymbol(): string
    {
        return '=';
    }
}
