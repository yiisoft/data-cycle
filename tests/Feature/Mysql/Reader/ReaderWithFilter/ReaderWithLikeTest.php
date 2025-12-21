<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithLikeTestCase;

final class ReaderWithLikeTest extends BaseReaderWithLikeTestCase
{
    public static ?string $DRIVER = 'mysql';

    public static function dataWithReader(): array
    {
        $data = parent::dataWithReader();
        $data['search: contains, same case, case sensitive: true'] = ['email', 'ed@be', true, [2]];
        $data['search: contains, different case, case sensitive: true'] = ['email', 'SEED@', true, []];

        return $data;
    }
}
