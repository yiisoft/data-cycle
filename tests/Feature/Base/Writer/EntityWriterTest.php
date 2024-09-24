<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Writer;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;
use Yiisoft\Data\Cycle\Writer\EntityWriter;
use Yiisoft\Data\Tests\Common\FixtureTrait;

abstract class EntityWriterTest extends TestCase
{
    use DataTrait;
    use FixtureTrait;

    public function testWrite(): void
    {
        $orm = $this->getOrm();

        $writer = new EntityWriter($this->createEntityManager());
        $writer->write($users = [
            $orm->make('user', ['number' => 99998, 'email' => 'super@test1.com', 'balance' => 1000.0]),
            $orm->make('user', ['number' => 99999, 'email' => 'super@test2.com', 'balance' => 999.0]),
        ]);

        $reader = new EntityReader(
            $this->select('user')->where('number', 'in', [99998, 99999]),
        );
        $this->assertEquals($users, $reader->read());
    }

    public function testDelete(): void
    {
        $writer = new EntityWriter($this->createEntityManager());
        $reader = new EntityReader($this->select('user')->where('number', 'in', [1, 2, 3]));
        // Iterator doesn't use cache
        $entities = \iterator_to_array($reader->getIterator());

        $writer->delete($entities);

        $this->assertCount(3, $entities);
        $this->assertEquals([], \iterator_to_array($reader->getIterator()));
    }
}
