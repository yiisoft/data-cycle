<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Data\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\FilterHandler\InHandler;
use PHPUnit\Framework\TestCase;

final class InHandlerTest extends TestCase
{
    public function testInvalidArgumentsException(): void
    {
        $handler = new InHandler();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$arguments should contain exactly two elements.');
        $handler->getAsWhereArguments([], []);
    }
}
