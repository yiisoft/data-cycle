<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Data\Reader\FilterHandler;

use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\Data\BaseData;
use Yiisoft\Data\Reader\Filter\Equals;

final class AllHandlerTest extends BaseData
{
    public function testAllHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))
            ->withFilter((new All(new Equals('balance', '100.0'), new Equals('email', 'seed@beat'))));

        $this->assertEquals([(object)self::FIXTURES_USER[2]], $reader->read());
    }

    public function testInvalidOperatorException(): void
    {
        $this->markTestSkipped();
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Filter operator "?" is not supported.');
        (new EntityReader($this->select('user')))->withFilter((new All())->withCriteriaArray([
            ['?', 'email', 'seed@beat'],
        ]));
    }
}
