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
        $data['search: contains, same case, case sensitive: true'] = ['email', 'ed@be', true, [2]];
        $data['search: contains, different case, case sensitive: true'] = ['email', 'SEED@', true, []];

        return $data;
    }
}
