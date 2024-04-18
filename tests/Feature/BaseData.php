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

class BaseData extends TestCase
{
    public const DRIVER = null;

    protected const FIXTURES_USER = [
        ['id' => 1, 'email' => 'foo@bar', 'balance' => '10.25', 'born_at' => null],
        ['id' => 2, 'email' => 'bar@foo', 'balance' => '1.0', 'born_at' => null],
        ['id' => 3, 'email' => 'seed@beat', 'balance' => '100.0', 'born_at' => null],
        ['id' => 4, 'email' => 'the@best', 'balance' => '500.0', 'born_at' => null],
        ['id' => 5, 'email' => 'test@test', 'balance' => '42.0', 'born_at' => '1990-01-01'],
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
        return new DatabaseManager(new DatabaseConfig([
            'databases' => [
                'default' => ['connection' => static::DRIVER ?? 'sqlite'],
                'sqlite' => ['connection' => 'sqlite'],
                'mysql' => ['connection' => 'mysql'],
                'pgsql' => ['connection' => 'pgsql'],
                'mssql' => ['connection' => 'mssql'],
            ],
            'connections' => [
                'sqlite' => new SQLiteDriverConfig(
                    connection: new MemoryConnectionConfig(),
                    queryCache: true,
                ),
                'mysql' => new MySQLDriverConfig(
                    connection: new MySQLTcpConnectionConfig(
//                        database: $_ENV['CYCLE_MYSQL_DATABASE'],
//                        host: $_ENV['CYCLE_MYSQL_HOST'],
//                        port: (int) $_ENV['CYCLE_MYSQL_PORT'],
//                        user: $_ENV['CYCLE_MYSQL_USER'],
//                        password: $_ENV['CYCLE_MYSQL_PASSWORD'],
                        database: 'yiitest',
                        host: '127.0.0.1',
                        port: 3306,
                        user: 'root',
                        password: '',
                    ),
                    queryCache: true,
                ),
                'pgsql' => new PostgresDriverConfig(
                    connection: new PostgresTcpConnectionConfig(
                        database: $_ENV['CYCLE_PGSQL_DATABASE'],
                        host: $_ENV['CYCLE_PGSQL_HOST'],
                        port: (int) $_ENV['CYCLE_PGSQL_PORT'],
                        user: $_ENV['CYCLE_PGSQL_USER'],
                        password: $_ENV['CYCLE_PGSQL_PASSWORD'],
                    ),
                    schema: 'public',
                    queryCache: true,
                ),
                'mssql' => new SQLServerDriverConfig(
                    connection: new SQLServerTcpConnectionConfig(
                        database: $_ENV['CYCLE_MSSQL_DATABASE'],
                        host: $_ENV['CYCLE_MSSQL_HOST'],
                        port: (int) $_ENV['CYCLE_MSSQL_PORT'],
                        user: $_ENV['CYCLE_MSSQL_USER'],
                        password: $_ENV['CYCLE_MSSQL_PASSWORD'],
                    ),
                    queryCache: true,
                ),
            ],
        ]));
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
        $user->column('id')->bigInteger()->primary();
        $user->column('email')->string()->nullable(false);
        $user->column('balance')->float()->nullable(false)->defaultValue(0.0);
        $user->column('born_at')->date()->nullable();
        $user->save();

        $db->insert('user')
            ->columns(['id', 'email', 'balance', 'born_at'])
            ->values(static::FIXTURES_USER)
            ->run();
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
     * Send sample query in a form where all quotation symbols replaced with { and }.
     */
    protected function assertSameQuery(string $expectedQuery, string $actialQuery): void
    {
        // Preparing query
        $expectedQuery = str_replace(
            ['{', '}'],
            explode('\a', $this->dbal->database()->getDriver()->identifier('\a')),
            $expectedQuery,
        );

        $this->assertSame(preg_replace('/\s+/', '', $expectedQuery), preg_replace('/\s+/', '', $actialQuery));
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
}
