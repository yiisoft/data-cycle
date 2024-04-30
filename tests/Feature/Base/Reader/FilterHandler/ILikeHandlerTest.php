<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use PHPUnit\Framework\Attributes\DataProvider;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\ILike;

abstract class ILikeHandlerTest extends BaseData
{
    public static function dataBase(): array
    {
        return [
            'case matches' => ['email', 'seed@%', [2]],
            'case does not match' => ['email', 'SEED@%', [2]],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $field, string $value, array $expectedFixtureIndexes): void
    {
        $reader = (new EntityReader($this->select('user')))->withFilter(new ILike($field, $value));
        $this->assertFixtures($expectedFixtureIndexes, $reader->read());
    }
}
