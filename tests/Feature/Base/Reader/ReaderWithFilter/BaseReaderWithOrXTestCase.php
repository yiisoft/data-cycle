<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;
use Yiisoft\Data\Cycle\Tests\Support\NotSupportedFilter;
use Yiisoft\Data\Reader\Filter\OrX;
use Yiisoft\Data\Reader\Filter\Equals;

abstract class BaseReaderWithOrXTestCase extends \Yiisoft\Data\Tests\Common\Reader\ReaderWithFilter\BaseReaderWithAnyTestCase
{
    use DataTrait;

    public function testNotsupportedFilterException(): void
    {
        $reader = (new EntityReader($this->select('user')));

        $this->expectException(NotSupportedFilterException::class);
        $this->expectExceptionMessage(sprintf('Filter "%s" is not supported.', NotSupportedFilter::class));
        $reader->withFilter(new OrX(new Equals('number', 2), new NotSupportedFilter(), new Equals('number', 3)));
    }
}
