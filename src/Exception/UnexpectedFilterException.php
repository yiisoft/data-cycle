<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Exception;

use InvalidArgumentException;
use Throwable;

final class UnexpectedFilterException extends InvalidArgumentException
{
    public function __construct(
        /**
         * @var string Expected class name of a filter.
         */
        string $expectedClassName,
        /**
         * @var object An actual given filter that's not an instance of specific filter with `$expectedClassName`.
         */
        string $actualClassName,
        /**
         * @var int The Exception code.
         */
        int $code = 0,
        /**
         * @var Throwable|null The previous throwable used for the exception chaining.
         */
        ?Throwable $previous = null,
    ) {
        parent::__construct(
            sprintf(
                'Expected "%s", but "%s" given.',
                $expectedClassName,
                $actualClassName,
            ),
            $code,
            $previous,
        );
    }
}
