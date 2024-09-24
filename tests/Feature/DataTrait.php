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
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Reader\DataReaderInterface;

trait DataTrait
{
    public static $DRIVER = null;

    // cache
    private ?ORMInterface $orm = null;
    private ?DatabaseProviderInterface $dbal = null;

    protected function setUp(): void
    {
        $this->dbal ??= $this->createDbal();

        $this->orm ??= $this->createOrm();
        $this->assertInstanceOf(ORMInterface::class, $this->getOrm());

        $this->fillFixtures();
    }

    protected function tearDown(): void
    {
        $this->dropDatabase();
        $this->orm = null;
        $this->dbal = null;
    }

    private function createDbal(): DatabaseProviderInterface
    {
        $databases = [
            'default' => ['connection' => static::$DRIVER ?? 'sqlite'],
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
                    trustServerCertificate: true,
                    user: getenv('CYCLE_MSSQL_USER'),
                    password: getenv('CYCLE_MSSQL_PASSWORD'),
                ),
                queryCache: true,
            );
        }

        return new DatabaseManager(new DatabaseConfig(['databases' => $databases, 'connections' => $connections]));
    }

    protected function dropDatabase(): void
    {
        foreach ($this->dbal->database()->getTables() as $table) {
            $schema = $table->getSchema();

            foreach ($schema->getForeignKeys() as $foreign) {
                $schema->dropForeignKey($foreign->getColumns());
            }

            $schema->save(Handler::DROP_FOREIGN_KEYS);
        }

        foreach ($this->dbal->database()->getTables() as $table) {
            $schema = $table->getSchema();
            $schema->declareDropped();
            $schema->save();
        }
    }

    protected function fillFixtures(): void
    {
        /** @var Database $db */
        $db = $this->dbal->database();
        if ($db->hasTable('user')) {
            return;
        }

        $user = $db->table('user')->getSchema();
        $user->column('id')->primary();
        $user->column('number')->integer();
        $user->column('email')->string()->nullable(false);
        $user->column('balance')->float()->nullable(false)->defaultValue(0.0);
        $user->column('born_at')->date()->nullable();
        $user->save();

        $fixtures = static::$fixtures;
        foreach ($fixtures as $index => $fixture) {
            $fixtures[$index]['balance'] = (string) $fixtures[$index]['balance'];
        }

        $db
            ->insert('user')
            ->columns(['number', 'email', 'balance', 'born_at'])
            ->values($fixtures)
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
                    'number' => 'int',
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

    protected function getReader(): DataReaderInterface
    {
        return new EntityReader($this->select('user'));
    }
}
