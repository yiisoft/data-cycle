<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter;

use PHPUnit\Framework\Attributes\DataProvider;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;

abstract class BaseReaderWithLikeTestCase extends \Yiisoft\Data\Tests\Common\Reader\ReaderWithFilter\BaseReaderWithLikeTestCase
{
    use DataTrait;

    #[\Override]
    public static function dataWithReader(): array
    {
        $data = parent::dataWithReader();
        $data['search: contains, different case, case sensitive: null'] = ['email', 'SEED@', null, [2]];

        return $data;
    }

    #[DataProvider('dataWithReader'), \Override]
    public function testWithReader(string $field, string $value, ?bool $caseSensitive, array $expectedFixtureIndexes): void
    {
        // Prevents errors in case-sensitive LIKE on SQLite
        if ($this->isSqlite() && $caseSensitive === true) {
            $this->expectException(\Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException::class);
        }

        parent::testWithReader($field, $value, $caseSensitive, $expectedFixtureIndexes);
    }
}
