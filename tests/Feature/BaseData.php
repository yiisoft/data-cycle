<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Database;
use Cycle\Database\DatabaseManager;
use Cycle\Database\DatabaseProviderInterface;
use Cycle\ORM\EntityManager;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\Factory;
use Cycle\ORM\Mapper\StdMapper;
use Cycle\ORM\ORM;
use Cycle\ORM\ORMInterface;
use Cycle\ORM\Schema;
use Cycle\ORM\SchemaInterface;
use Cycle\ORM\Select;
use PHPUnit\Framework\TestCase;
use Yiisoft\Test\Support\Container\SimpleContainer;

class BaseData extends TestCase
{
    protected const FIXTURES_USER = [
        ['id' => 1, 'email' => 'foo@bar', 'balance' => '10.25'],
        ['id' => 2, 'email' => 'bar@foo', 'balance' => '1.0'],
        ['id' => 3, 'email' => 'seed@beat', 'balance' => '100.0'],
        ['id' => 4, 'email' => 'the@best', 'balance' => '500.0'],
        ['id' => 5, 'email' => 'test@test', 'balance' => '42.0'],
    ];

    protected ?SimpleContainer $container = null;
    // cache
    private ?ORMInterface $orm = null;
    private ?DatabaseProviderInterface $dbal = null;

    public function testDefinitions(): void
    {
        self::assertInstanceOf(ORMInterface::class, $this->getOrm());
    }

    protected function setUp(): void
    {
        $this->dbal ??= $this->createDbal();
        $this->orm ??= $this->createOrm();
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->orm = null;
        $this->dbal = null;
        $this->container = null;
    }

    protected function fillFixtures(): void
    {
        /** @var Database $db */
        $db = $this->dbal->database();

        $user = $db->table('user')->getSchema();
        $user->column('id')->bigInteger()->primary();
        $user->column('email')->string(255)->nullable(false);
        $user->column('balance')->float()->nullable(false)->defaultValue(0.0);
        $user->save();

        $db->insert('user')
            ->columns(['id', 'email', 'balance'])
            ->values(static::FIXTURES_USER)
            ->run();
    }

    protected function dbalConfig(): array
    {
        return [
            // SQL query logger. Definition of Psr\Log\LoggerInterface
            'query-logger' => null,
            // Default database
            'default' => 'default',
            'aliases' => [],
            'databases' => [
                'default' => ['connection' => 'sqlite'],
            ],
            'connections' => [
                'sqlite' => new \Cycle\Database\Config\SQLiteDriverConfig(
                    connection: new \Cycle\Database\Config\SQLite\MemoryConnectionConfig()
                ),
            ],
        ];
    }

    protected function select(string $role): Select
    {
        return new Select($this->getOrm(), $role);
    }

    protected function getOrm(): ORMInterface
    {
        return $this->orm;
    }

    private function createOrm(): ORMInterface
    {
        return new ORM(factory: new Factory($this->dbal), schema: $this->createSchema());
    }

    /**
     * Cycle ORM Schema
     */
    private function createSchema(): SchemaInterface
    {
        return new Schema([
            'user' => [
                SchemaInterface::MAPPER => StdMapper::class,
                SchemaInterface::DATABASE => 'default',
                SchemaInterface::TABLE => 'user',
                SchemaInterface::PRIMARY_KEY => 'id',
                SchemaInterface::COLUMNS => [
                    // property => column
                    'id' => 'id',
                    'email' => 'email',
                    'balance' => 'balance',
                ],
                SchemaInterface::TYPECAST => [
                    'id' => 'int',
                    'balance' => 'float',
                ],
                SchemaInterface::RELATIONS => [],
            ],
        ]);
    }

    private function createDbal(): DatabaseProviderInterface
    {
        return new DatabaseManager(new DatabaseConfig($this->dbalConfig()));
    }

    protected function createEntityManager(): EntityManagerInterface
    {
        return new EntityManager($this->orm);
    }
}
