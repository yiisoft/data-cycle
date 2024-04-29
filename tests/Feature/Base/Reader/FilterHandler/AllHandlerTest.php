<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Cycle\Tests\Support\NotSupportedFilter;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\Filter\Equals;

abstract class AllHandlerTest extends BaseData
{
    public function testAllHandler(): void
    {
        $reader = (new EntityReader($this->select('user')))
            ->withFilter(new All(new Equals('balance', '100.0'), new Equals('email', 'seed@beat')));
        $this->assertFixtures([2], $reader->read());
    }

    public function testNotSupportedFilterException(): void
    {
        $reader = (new EntityReader($this->select('user')));

        $this->expectException(NotSupportedFilterException::class);
        $this->expectExceptionMessage(sprintf('Filter "%s" is not supported.', NotSupportedFilter::class));
        $reader->withFilter(
            new All(new Equals('balance', '100.0'), new NotSupportedFilter(), new Equals('email', 'seed@beat')),
        );
    }
}
