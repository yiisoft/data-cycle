<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader;

interface QueryBuilderFilterHandler
{
    public function getAsWhereArguments(array $arguments, array $handlers): array;
}
