<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;
use Yiisoft\Data\Reader\Filter\None;

abstract class BaseReaderWithNoneTestCase extends \Yiisoft\Data\Tests\Common\Reader\ReaderWithFilter\BaseReaderWithNoneTestCase
{
    use DataTrait;

    public function testFilterSupportSelectQuery(): void
    {
        $reader = (new EntityReader(
            $this
                ->select('user')
                ->buildQuery()
                ->columns('id', 'balance'),
        ));

        $reader = $reader->withFilter(new None());
        $result = $reader->read();

        $this->assertSame([], $result);
    }
}
