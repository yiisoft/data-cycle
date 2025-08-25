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
    public static string $DRIVER = '';

    // cache
    private ?ORMInterface $orm = null;
    private ?DatabaseProviderInterface $dbal = null;
    
    protected function isDriver(string $driver): bool
    {
        return static::$DRIVER === $driver;
    }

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
            'default' => ['connection' => static::$DRIVER ?: 'sqlite'],
            'sqlite' => ['connection' => 'sqlite'],
        ];
        $connections = [
            'sqlite' => new SQLiteDriverConfig(
                connection: new MemoryConnectionConfig(),
                queryCache: true,
            ),
        ];

        if (($database = getenv('CYCLE_MYSQL_DATABASE', local_only: true)) !== false && $database !== '') {
            $databases['mysql'] = ['connection' => 'mysql'];
            if (($host = getenv('CYCLE_MYSQL_HOST', local_only: true)) !== false && $host !== '') {
                if (($port = getenv('CYCLE_MYSQL_PORT', local_only: true)) !== false && $port !== '' && (int) $port > 0 && is_numeric($port)) {
                    if (($user = getenv('CYCLE_MYSQL_USER', local_only: true)) !== false && $user !== '') {
                        if (($password = getenv('CYCLE_MYSQL_PASSWORD', local_only: true)) !== false) {
                            $connections['mysql'] = new MySQLDriverConfig(
                                connection: new MySQLTcpConnectionConfig(
                                    database: $database,
                                    host: $host,
                                    port: $port,
                                    user: $user,
                                    password: $password === '' ? null : $password,
                                ),
                                queryCache: true,
                            );
                        }
                    }
                }
            }
        }

        if (($database = getenv('CYCLE_PGSQL_DATABASE', local_only: true)) !== false && $database !== '') {
            $databases['pgsql'] = ['connection' => 'pgsql'];
            if (($host = getenv('CYCLE_PGSQL_HOST', local_only: true)) !== false && $host !== '') {
                if (($port = getenv('CYCLE_PGSQL_PORT', local_only: true)) !== false && $port !== '' && (int) $port > 0 && is_numeric($port)) {
                    if (($user = getenv('CYCLE_PGSQL_USER', local_only: true)) !== false && $user !== '') {
                        if (($password = getenv('CYCLE_PGSQL_PASSWORD', local_only: true)) !== false) {
                            $connections['pgsql'] = new PostgresDriverConfig(
                                connection: new PostgresTcpConnectionConfig(
                                    database: $database,
                                    host: $host,
                                    port: $port,
                                    user: $user,
                                    password: $password === '' ? null : $password,
                                ),
                                schema: 'public',
                                queryCache: true,
                            );
                        }
                    }
                }
            }
        }

        if (($database = getenv('CYCLE_MSSQL_DATABASE', local_only: true)) !== false && $database !== '') {
            $databases['mssql'] = ['connection' => 'mssql'];
            if (($host = getenv('CYCLE_MSSQL_HOST', local_only: true)) !== false && $host !== '') {
                if (($port = getenv('CYCLE_MSSQL_PORT', local_only: true)) !== false && $port !== '' && (int) $port > 0 && is_numeric($port)) {
                    if (($user = getenv('CYCLE_MSSQL_USER', local_only: true)) !== false && $user !== '') {
                        if (($password = getenv('CYCLE_MSSQL_PASSWORD', local_only: true)) !== false) {
                            $connections['mssql'] = new SQLServerDriverConfig(
                                connection: new SQLServerTcpConnectionConfig(
                                    database: $database,
                                    host: $host,
                                    port: $port,
                                    user: $user,
                                    trustServerCertificate: true,    
                                    password: $password === '' ? null : $password,
                                ),
                                queryCache: true,
                            );
                        }
                    }
                }
            }
        }

        return new DatabaseManager(new DatabaseConfig(['databases' => $databases, 'connections' => $connections]));
    }

    protected function dropDatabase(): void
    {
        if ($this->dbal === null) {
            throw new \RuntimeException('DBAL not initialized');
        }

        /** @var \Cycle\Database\Table $table */
        foreach ($this->dbal->database()->getTables() as $table) {
            /** @var \Cycle\Database\Schema\AbstractTable $schema */
            $schema = $table->getSchema();

            foreach ($schema->getForeignKeys() as $foreign) {
                $schema->dropForeignKey($foreign->getColumns());
            }

            $schema->save(\Cycle\Database\Driver\Handler::DROP_FOREIGN_KEYS);
        }

        /** @var \Cycle\Database\Table $table */
        foreach ($this->dbal->database()->getTables() as $table) {
            /** @var \Cycle\Database\Schema\AbstractTable $schema */
            $schema = $table->getSchema();
            $schema->declareDropped();
            $schema->save();
        }
    }

    protected function fillFixtures(): void
    {
        assert($this->dbal !== null);
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
        $user->column('born_at')->datetime()->nullable();
        $user->save();

        /** @var array<int, array<string, mixed>> $fixtures */
        $fixtures = $this->getFixtures();
        /** @var array<string, mixed> $fixture */
        foreach ($fixtures as $index => $fixture) {
            $fixtures[$index]['balance'] = (string) $fixtures[$index]['balance'];
            if (
                isset($fixtures[$index]['born_at']) &&
                $fixtures[$index]['born_at'] instanceof \DateTimeInterface
            ) {
                // Use a standard format for storing dates as string
                $fixtures[$index]['born_at'] = $fixtures[$index]['born_at']->format('Y-m-d H:i:s');
            }
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
        if ($this->orm === null) {
            throw new \RuntimeException('ORM is not initialized');
        }
        return $this->orm;
    }

    private function createOrm(): ORMInterface
    {
        if ($this->dbal === null) {
            throw new \RuntimeException('DBAL is not initialized');
        }
        return new ORM(factory: new Factory($this->dbal), schema: $this->createSchema());
    }

    protected function getDatabase(): DatabaseInterface
    {
        if ($this->dbal === null) {
            throw new \RuntimeException('DBAL is not initialized');
        }
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

    protected function createEntityManager(): ?EntityManagerInterface
    {
        $orm = $this->orm;
        if (null !== $orm) {
            return new EntityManager($orm);
        }
        return null;
    }

    protected function getReader(): DataReaderInterface
    {
        return new EntityReader($this->select('user'));
    }

    protected function assertFixtures(array $expectedFixtureIndexes, array $actualFixtures): void
    {
        $processedActualFixtures = [];
        /**
         * @var array $fixture
         */
        foreach ($actualFixtures as $fixture) {
            /** @var array<string, mixed>|object $fixture */
            if (is_object($fixture)) {
                $json = json_encode($fixture);
                if ($json === false) {
                    throw new \RuntimeException('Failed to JSON-encode fixture');
                }
                /** @var array<string, mixed> $fixture */
                $fixture = json_decode($json, associative: true);
            }

            unset($fixture['id']);
            $fixture['number'] = (int) $fixture['number'];
            $fixture['balance'] = (float) $fixture['balance'];

            // Ensure born_at is normalized for comparison:
            // - null stays null
            // - string or object is converted to string 'Y-m-d H:i:s'
            if (isset($fixture['born_at']) && $fixture['born_at'] !== null) {
                if ($fixture['born_at'] instanceof \DateTimeInterface) {
                    $fixture['born_at'] = $fixture['born_at']->format('Y-m-d H:i:s');
                } elseif (is_string($fixture['born_at']) && $fixture['born_at'] !== '') {
                    // Remove milliseconds if present (MSSQL returns .000)
                    $normalized = preg_replace('/\\.\\d{3}$/', '', $fixture['born_at']);
                    // Try to parse as date and reformat to standard string (for DB vs object test comparisons)
                    if ($normalized !== null && $normalized !== '') {
                        $dt = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $normalized)
                            ?: \DateTimeImmutable::createFromFormat('Y-m-d', $normalized);
                        if ($dt !== false) {
                            $fixture['born_at'] = $dt->format('Y-m-d H:i:s');
                        } else {
                            $fixture['born_at'] = $normalized;
                        }
                    } else {
                        $fixture['born_at'] = $normalized;
                    } 
                }
            }

            $processedActualFixtures[$fixture['number'] - 1] = $fixture;
        }

        $expectedFixtures = [];
        /**
         * @var int $index
         */
        foreach ($expectedFixtureIndexes as $index) {
            $expectedFixture = $this->getFixture($index);
            // Normalize born_at for expected fixtures as well
            if (isset($expectedFixture['born_at']) && $expectedFixture['born_at'] instanceof \DateTimeInterface) {
                $expectedFixture['born_at'] = $expectedFixture['born_at']->format('Y-m-d H:i:s');
            }
            $expectedFixtures[$index] = $expectedFixture;
        }

        $this->assertSame($expectedFixtures, $processedActualFixtures);
    }
}
