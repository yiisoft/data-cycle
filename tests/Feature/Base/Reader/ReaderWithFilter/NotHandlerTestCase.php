<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\BaseReaderTestCase;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;
use Yiisoft\Data\Cycle\Tests\Support\NotSupportedFilter;
use Yiisoft\Data\Reader\Filter\Not;

abstract class NotHandlerTestCase extends BaseReaderTestCase
{
    use DataTrait;

    public function testNotSupportedFilterException(): void
    {
        $reader = (new EntityReader($this->select('user')));

        $this->expectException(NotSupportedFilterException::class);
        $this->expectExceptionMessage(sprintf('Filter "%s" is not supported.', NotSupportedFilter::class));
        $reader->withFilter(new Not(new NotSupportedFilter()));
    }
}
