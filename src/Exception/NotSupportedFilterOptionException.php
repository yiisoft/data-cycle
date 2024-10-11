<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Exception;

use InvalidArgumentException;
use Throwable;

final class NotSupportedFilterOptionException extends InvalidArgumentException
{
    /**
     * @param string $optionName Option name in filter.
     * @param string $driverType Driver type of database.
     */
    public function __construct(string $optionName, string $driverType, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("\$$optionName option is not supported when using $driverType driver.", $code, $previous);
    }
}
