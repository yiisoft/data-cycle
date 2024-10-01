<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithLikeTestCase;

final class ReaderWithLikeTest extends BaseReaderWithLikeTestCase
{
    public static $DRIVER = 'pgsql';

    public static function dataWithReader(): array
    {
        $data = parent::dataWithReader();
        $data['case does not match, contains search string, case sensitive: null'][3] = [];

        return $data;
    }
}
