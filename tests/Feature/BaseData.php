<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\MySQL\TcpConnectionConfig as MySQLTcpConnectionConfig;
use Cycle\Database\Config\MySQLDriverConfig;
use Cycle\Database\Config\Postgres\TcpConnectionConfig as PostgresTcpConnectionConfig;
use Cycle\Database\Config\PostgresDriverConfig;
use Cycle\Database\Config\SQLite\MemoryConnectionConfig;
use Cycle\Database\Config\SQLiteDriverConfig;
use Cycle\Database\Config\SQLServer\TcpConnectionConfig as SQLServerTcpConnectionConfig;
use Cycle\Database\Config\SQLServerDriverConfig;
use Cycle\Database\Database;
use Cycle\Database\DatabaseInterface;
use Cycle\Database\DatabaseManager;
use Cycle\Database\DatabaseProviderInterface;
use Cycle\Database\Driver\Handler;
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
use Yiisoft\Data\Reader\DataReaderInterface;

class BaseData extends TestCase
{
    public const DRIVER = null;

    protected const FIXTURES_USER = [
        ['number' => 1, 'email' => 'foo@bar', 'balance' => 10.25, 'born_at' => null],
        ['number' => 2, 'email' => 'bar@foo', 'balance' => 1, 'born_at' => null],
        ['number' => 3, 'email' => 'seed@beat', 'balance' => 100, 'born_at' => null],
        ['number' => 4, 'email' => 'the@best', 'balance' => 500, 'born_at' => null],
        ['number' => 5, 'email' => 'test@test', 'balance' => 42, 'born_at' => '1990-01-01'],
    ];

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
    }

    protected function tearDown(): void
    {
        $this->dropDatabase($this->dbal->database());
        $this->orm = null;
        $this->dbal = null;
    }

    private function createDbal(): DatabaseProviderInterface
    {
        $databases = [
            'default' => ['connection' => static::DRIVER ?? 'sqlite'],
            'sqlite' => ['connection' => 'sqlite'],
        ];
        $connections = [
            'sqlite' => new SQLiteDriverConfig(
                connection: new MemoryConnectionConfig(),
                queryCache: true,
            ),
        ];

        if (getenv('CYCLE_MYSQL_DATABASE', local_only: true) !== false) {
            $databases['mysql'] = ['connection' => 'mysql'];
            $connections['mysql'] = new MySQLDriverConfig(
                connection: new MySQLTcpConnectionConfig(
                    database: getenv('CYCLE_MYSQL_DATABASE'),
                    host: getenv('CYCLE_MYSQL_HOST'),
                    port: (int) getenv('CYCLE_MYSQL_PORT'),
                    user: getenv('CYCLE_MYSQL_USER'),
                    password: getenv('CYCLE_MYSQL_PASSWORD'),
                ),
                queryCache: true,
            );
        }

        if (getenv('CYCLE_PGSQL_DATABASE', local_only: true) !== false) {
            $databases['pgsql'] = ['connection' => 'pgsql'];
            $connections['pgsql'] = new PostgresDriverConfig(
                connection: new PostgresTcpConnectionConfig(
                    database: getenv('CYCLE_PGSQL_DATABASE'),
                    host: getenv('CYCLE_PGSQL_HOST'),
                    port: (int) getenv('CYCLE_PGSQL_PORT'),
                    user: getenv('CYCLE_PGSQL_USER'),
                    password: getenv('CYCLE_PGSQL_PASSWORD'),
                ),
                schema: 'public',
                queryCache: true,
            );
        }

        if (getenv('CYCLE_MSSQL_DATABASE', local_only: true) !== false) {
            $databases['mssql'] = ['connection' => 'mssql'];
            $connections['mssql'] = new SQLServerDriverConfig(
                connection: new SQLServerTcpConnectionConfig(
                    database: getenv('CYCLE_MSSQL_DATABASE'),
                    host: getenv('CYCLE_MSSQL_HOST'),
                    port: (int) getenv('CYCLE_MSSQL_PORT'),
                    user: getenv('CYCLE_MSSQL_USER'),
                    password: getenv('CYCLE_MSSQL_PASSWORD'),
                ),
                queryCache: true,
            );
        }

        return new DatabaseManager(new DatabaseConfig(['databases' => $databases, 'connections' => $connections]));
    }

    protected function dropDatabase(?DatabaseInterface $database = null): void
    {
        if ($database === null) {
            return;
        }

        foreach ($database->getTables() as $table) {
            $schema = $table->getSchema();

            foreach ($schema->getForeignKeys() as $foreign) {
                $schema->dropForeignKey($foreign->getColumns());
            }

            $schema->save(Handler::DROP_FOREIGN_KEYS);
        }

        foreach ($database->getTables() as $table) {
            $schema = $table->getSchema();
            $schema->declareDropped();
            $schema->save();
        }
    }

    protected function fillFixtures(): void
    {
        /** @var Database $db */
        $db = $this->dbal->database();

        $user = $db->table('user')->getSchema();
        $user->column('id')->integer()->primary();
        $user->column('number')->integer();
        $user->column('email')->string()->nullable(false);
        $user->column('balance')->float()->nullable(false)->defaultValue(0.0);
        $user->column('born_at')->date()->nullable();
        $user->save();

        if (static::DRIVER === 'mssql') {
            $db->execute('SET IDENTITY_INSERT [user] ON');
        }

        $db
            ->insert('user')
            ->columns(['number', 'email', 'balance', 'born_at'])
            ->values(static::FIXTURES_USER)
            ->run();

        if (static::DRIVER === 'mssql') {
            $db->execute('SET IDENTITY_INSERT [user] OFF');
        }
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

    protected function getDatabase(): DatabaseInterface
    {
        return $this->dbal->database();
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
                    'number' => 'number',
                    'email' => 'email',
                    'balance' => 'balance',
                    'born_at' => 'born_at',
                ],
                SchemaInterface::TYPECAST => [
                    'id' => 'int',
                    'balance' => 'float',
                ],
                SchemaInterface::RELATIONS => [],
            ],
        ]);
    }

    protected function createEntityManager(): EntityManagerInterface
    {
        return new EntityManager($this->orm);
    }

    protected function assertFixtures(array $expectedFixtureIndexes, array $actualFixtures): void
    {
        $expectedFixtures = array_map(
            static fn (int $expectedNumber) => self::FIXTURES_USER[$expectedNumber],
            $expectedFixtureIndexes,
        );
        $actualFixtures = array_map(
            static function (object $fixture): array {
                $fixture = json_decode(json_encode($fixture), associative: true);
                unset($fixture['id']);

                return $fixture;
            },
            $actualFixtures,
        );
        $this->assertSame($expectedFixtures, $actualFixtures);
    }
}
