<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Writer;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Cycle\Writer\EntityWriter;

abstract class EntityWriterTest extends BaseData
{
    public function testWrite(): void
    {
        $this->fillFixtures();
        $orm = $this->getOrm();

        $writer = new EntityWriter($this->createEntityManager());
        $writer->write($users = [
            $orm->make('user', ['id' => 99998, 'email' => 'super@test1.com', 'balance' => 1000.0]),
            $orm->make('user', ['id' => 99999, 'email' => 'super@test2.com', 'balance' => 999.0]),
        ]);

        $reader = new EntityReader(
            $this->select('user')->where('id', 'in', [99998, 99999]),
        );

        self::assertEquals($users, $reader->read());
    }

    public function testDelete(): void
    {
        $this->fillFixtures();

        $writer = new EntityWriter($this->createEntityManager());
        $reader = new EntityReader($this->select('user')->where('id', 'in', [1, 2, 3]));
        // Iterator doesn't use cache
        $entities = \iterator_to_array($reader->getIterator());

        $writer->delete($entities);

        self::assertCount(3, $entities);
        self::assertEquals([], \iterator_to_array($reader->getIterator()));
    }
}
