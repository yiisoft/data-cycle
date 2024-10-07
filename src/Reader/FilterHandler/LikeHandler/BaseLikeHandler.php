<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Cycle\Database\Injection\Fragment;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterInterface;

abstract class BaseLikeHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    private array $escapingReplacements = [
        '%' => '\%',
    ];

    public function getFilterClass(): string
    {
        return Like::class;
    }

    /**
     * @throws NotSupportedFilterOptionException When {@see Like::$caseSensitive} option is not supported with used
     * database driver.
     */
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof Like) {
            throw new UnexpectedFilterException(Like::class, $filter::class);
        }

        if ($filter->isCaseSensitive() !== true) {
            return [$filter->getField(), 'like', '%' . $filter->getValue() . '%'];
        }

        /** @infection-ignore-all mb_strtoupper -> strtoupper */
        return [new Fragment("UPPER({$filter->getField()})"), 'like', '%' . mb_strtoupper($filter->getValue()) . '%'];
    }

    protected function prepareValue(string $value): string
    {
        return '%' . strtr($value, $this->escapingReplacements) . '%';
    }
}
