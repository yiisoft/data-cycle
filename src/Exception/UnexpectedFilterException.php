<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Exception;

use InvalidArgumentException;
use Throwable;

final class UnexpectedFilterException extends InvalidArgumentException
{
    /**
     * @param string $expectedClassName Expected class name of a filter.
     * @psalm-param class-string $expectedClassName
     *
     * @param string $actualClassName An actual given filter that's not an instance of a specific filter with `$expectedClassName`.
     * @psalm-param class-string $actualClassName
     */
    public function __construct(
        string $expectedClassName,
        string $actualClassName,
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct("Expected \"$expectedClassName\", but \"$actualClassName\" given.", $code, $previous);
    }
}
