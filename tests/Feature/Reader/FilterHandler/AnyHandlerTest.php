<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Cycle\Tests\Support\NotSupportedFilter;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\GreaterThan;
use Yiisoft\Data\Reader\Filter\LessThan;
use Yiisoft\Data\Reader\Filter\Like;

final class AnyHandlerTest extends BaseData
{
    public function testAnyHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))
            ->withFilter((new Any(new Equals('id', 2), new Equals('id', 3))));

        $this->assertEquals([(object)self::FIXTURES_USER[1], (object)self::FIXTURES_USER[2]], $reader->read());
    }

    public function testNested(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))
            ->withFilter(
                new Any(
                    new All(new GreaterThan('balance', '500.0'), new LessThan('id', 5)),
                    new Like('email', '%st'),
                ));

        $this->assertEquals([(object) self::FIXTURES_USER[3], (object) self::FIXTURES_USER[4]], $reader->read());
    }

    public function testNotsupportedFilterException(): void
    {
        $reader = (new EntityReader($this->select('user')));

        $this->expectException(NotSupportedFilterException::class);
        $this->expectExceptionMessage(sprintf('Filter "%s" is not supported', NotSupportedFilter::class));
        $reader->withFilter((new Any(new Equals('id', 2), new NotSupportedFilter(), new Equals('id', 3))));
    }
}
