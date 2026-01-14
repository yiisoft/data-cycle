<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Stringable;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\Filter\LikeMode;
use Override;

abstract class BaseLikeHandler implements QueryBuilderFilterHandler
{
    protected array $escapingReplacements = [
        '%' => '\%',
        '_' => '\_',
        '\\' => '\\\\',
    ];

    #[Override]
    public function getFilterClass(): string
    {
        return Like::class;
    }

    protected function prepareValue(string|Stringable $value, LikeMode $mode): string
    {
        $value = strtr((string) $value, $this->escapingReplacements);
        return match ($mode) {
            LikeMode::Contains => '%' . $value . '%',
            LikeMode::StartsWith => $value . '%',
            LikeMode::EndsWith => '%' . $value,
        };
    }
}
