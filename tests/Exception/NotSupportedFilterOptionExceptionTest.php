<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException;

final class NotSupportedFilterOptionExceptionTest extends TestCase
{
    public function testBase(): void
    {
        $exception = new NotSupportedFilterOptionException(optionName: 'caseSensitive', driverType: 'SQLite');

        $this->assertSame('$caseSensitive option is not supported when using SQLite driver.', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }
}
