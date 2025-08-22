<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\Filter\LikeMode;
use Yiisoft\Data\Reader\FilterHandlerInterface;

abstract class BaseLikeHandler implements FilterHandlerInterface
{
    protected array $escapingReplacements = [
        '%' => '\%',
        '_' => '\_',
        '\\' => '\\\\',
    ];

    #[\Override]
    public function getFilterClass(): string
    {
        return Like::class;
    }

    /**
     * Prepare the SQL LIKE pattern according to LikeMode.
     * Accepts LikeMode as a parameter, defaulting to Contains for backward compatibility.
     */
    protected function prepareValue(string $value, LikeMode $mode = LikeMode::Contains): string
    {
        $escapedValue = strtr($value, $this->escapingReplacements);

        return match ($mode) {
            LikeMode::Contains => '%' . $escapedValue . '%',
            LikeMode::StartsWith => $escapedValue . '%',
            LikeMode::EndsWith => '%' . $escapedValue,
        };
    }
}