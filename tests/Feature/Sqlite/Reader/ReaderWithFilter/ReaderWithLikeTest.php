<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\ReaderWithFilter;

use PHPUnit\Framework\Attributes\DataProvider;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException;
use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithLikeTestCase;

final class ReaderWithLikeTest extends BaseReaderWithLikeTestCase
{
    public static ?string $DRIVER = 'sqlite';

    #[DataProvider('dataWithReader')]
    public function testWithReader(
        string $field,
        mixed $value,
        bool|null $caseSensitive,
        array $expectedFixtureIndexes,
    ): void {
        if ($caseSensitive === true) {
            $this->expectException(NotSupportedFilterOptionException::class);
            $this->expectExceptionMessage('$caseSensitive option is not supported when using SQLite driver.');
        }

        parent::testWithReader($field, $value, $caseSensitive, $expectedFixtureIndexes);
    }
}
