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

    /**
     * Refer to logic code: tests\features\DataTrait e.g. $this->isSqlite() and $this->isSqlServer()
     * @param string $field
     * @param string $value
     * @param bool|null $caseSensitive
     * @param array $expectedFixtureIndexes
     * @return void
     */
    #[DataProvider('dataWithReader'), \Override]
    public function testWithReader(string $field, string $value, ?bool $caseSensitive, array $expectedFixtureIndexes): void
    {
        
        // SQLite and SQL Server (MSSQL) are Not case sensitive for the LIKE operator by default.

        // Prevents errors in case-sensitive LIKE on SQLite since case-insensitive for ASCII characters by default 
        // Example: LIKE 'abc%' matches "abc", "ABC", "Abc", etc.
        if ($this->isSqlite() && $caseSensitive === true) {
            $this->expectException(\Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException::class);
        }
        
        // Prevents errors in case-sensitive LIKE on SqlServer since case-insensitive 
        // by default, because most SQL Server installations use a case-insensitive collation (e.g., Latin1_General_CI_AS).
        // Example: LIKE 'abc%' matches "abc", "ABC", "Abc", etc.
        // This is assuming you are not using a case-sensitive collation e.g. Latin1_General_CS_AS
        if ($this->isSqlServer() && $caseSensitive === true) {
            $this->expectException(\Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException::class);
        }
        
        parent::testWithReader($field, $value, $caseSensitive, $expectedFixtureIndexes);
    }
}
