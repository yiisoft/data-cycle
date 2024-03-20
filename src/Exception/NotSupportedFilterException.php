<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Exception;

use InvalidArgumentException;
use Throwable;

final class NotSupportedFilterException extends InvalidArgumentException
{
    /**
     * @param string $className An actual given filter class name that's not supported.
     */
    public function __construct(string $className, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Filter \"$className\" is not supported.", $code, $previous);
    }
}
