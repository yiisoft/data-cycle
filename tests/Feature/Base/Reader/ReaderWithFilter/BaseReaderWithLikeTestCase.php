<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;

abstract class BaseReaderWithLikeTestCase extends \Yiisoft\Data\Tests\Common\Reader\ReaderWithFilter\BaseReaderWithLikeTestCase
{
    use DataTrait;

    public static function dataWithReader(): array
    {
        $data = parent::dataWithReader();
        unset($data['search: contains, different case, case sensitive: false']);
        unset($data['search: contains, different case, case sensitive: true']);
        unset($data['wildcard is not supported']);

        return $data;
    }
}
