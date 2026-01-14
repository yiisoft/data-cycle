<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use PHPUnit\Framework\Attributes\DataProvider;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException;
use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithLikeTestCase;

final class ReaderWithLikeTest extends BaseReaderWithLikeTestCase
{
    public static ?string $DRIVER = 'mssql';

    #[DataProvider('dataWithReader')]
    public function testWithReader(
        string $field,
        mixed $value,
        ?bool $caseSensitive,
        array $expectedFixtureIndexes,
    ): void {
        if ($caseSensitive === true) {
            $this->expectException(NotSupportedFilterOptionException::class);
            $this->expectExceptionMessage('$caseSensitive option is not supported when using SQLServer driver.');
        }

        parent::testWithReader($field, $value, $caseSensitive, $expectedFixtureIndexes);
    }
}
