<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Data\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\FilterHandler\CompareHandler;
use PHPUnit\Framework\TestCase;

final class CompareHandlerTest extends TestCase
{
    public function testValidateArgumentsException(): void
    {
        $this->markTestSkipped();
        $handler = new class () extends CompareHandler {
            public function getFilterClass(): string
            {
            }

            protected function getSymbol(): string
            {
            }
        };

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$arguments should contain exactly two elements.');
        $handler->getAsWhereArguments(['id'], []);
    }
}
