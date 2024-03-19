<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\ORM\Select\QueryBuilder;
use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterInterface;

final class AnyHandler extends GroupHandler
{
    public function getFilterClass(): string
    {
        return Any::class;
    }

    /**
     * @psalm-param Any $filter
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
                    $select->orWhere(...$handler->getAsWhereArguments($subFilter, $handlers));
                }
            },
        ];
    }
}
