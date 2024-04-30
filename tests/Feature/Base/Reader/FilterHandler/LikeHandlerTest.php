<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use PHPUnit\Framework\Attributes\DataProvider;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\Like;

abstract class LikeHandlerTest extends BaseData
{
    public static function dataBase(): array
    {
        return [
            'case matches' => ['email', 'seed@%', [2]],
            'case does not match' => ['email', 'SEED@%', []],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $field, string $value, array $expectedFixtureIndexes): void
    {
        $reader = (new EntityReader($this->select('user')))->withFilter(new Like($field, $value));
        $this->assertFixtures($expectedFixtureIndexes, $reader->read());
    }
}
