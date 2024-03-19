<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Data\Reader\FilterHandler;

use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\Data\BaseData;
use Yiisoft\Data\Reader\Filter\Equals;

final class AnyHandlerTest extends BaseData
{
    public function testAnyHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))
            ->withFilter((new Any(new Equals('id', 2), new Equals('id', 3))));

        $this->assertEquals([(object)self::FIXTURES_USER[1], (object)self::FIXTURES_USER[2]], $reader->read());
    }

    public function testInvalidOperatorException(): void
    {
        $this->markTestSkipped();
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Filter operator "?" is not supported.');
        (new EntityReader($this->select('user')))->withFilter((new Any())->withCriteriaArray([
            ['?', 'id', 2],
        ]));
    }
}
