<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\ORM\Select\QueryBuilder;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterInterface;

final class AllHandler extends GroupHandler
{
    public function getFilterClass(): string
    {
        return All::class;
    }

    /**
     * @psalm-param All $filter
     */
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        // $this->validateArguments($arguments);
        return [
            static function (QueryBuilder $select) use ($filter, $handlers) {
                foreach ($filter->getFilters() as $subFilter) {
                    $handler = $handlers[$subFilter::class] ?? null;
                    if ($handler === null) {
                        throw new \RuntimeException(sprintf('Filter "%s" is not supported.', $subFilter::class));
                    }
                    /** @var QueryBuilderFilterHandler $handler */
                    $select->where(...$handler->getAsWhereArguments($subFilter, $handlers));
                }
            },
        ];
    }
}
