<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterHandlerInterface;

abstract class BaseLikeHandler implements FilterHandlerInterface
{
    private array $escapingReplacements = [
        '%' => '\%',
    ];

    public function getFilterClass(): string
    {
        return Like::class;
    }

    protected function prepareValue(string $value): string
    {
        return '%' . strtr($value, $this->escapingReplacements) . '%';
    }
}
