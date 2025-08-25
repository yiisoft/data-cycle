<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\Filter\LikeMode;
use Yiisoft\Data\Reader\FilterInterface;

final class SqliteLikeHandler extends BaseLikeHandler implements QueryBuilderFilterHandler
{
    protected array $escapingReplacements = [
        '%' => '\%',
        '_' => '\_',
    ];

    #[\Override]
    /**
     * @param FilterInterface $filter
     * @psalm-param Like $filter
     */
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        assert($filter instanceof Like);

        if (isset($filter->options['escape'])) {
            throw new NotSupportedFilterOptionException(
                'Escape option is not supported in SQLite LIKE queries.',
                'sqlite',
            );
        }

        /** @var Like $filter */

        $allowedModes = [LikeMode::Contains, LikeMode::StartsWith, LikeMode::EndsWith];
        // Psalm will now know $filter->mode is LikeMode
        $modeName = $filter->mode->name;

        if (!in_array($filter->mode, $allowedModes, true)) {
            throw new NotSupportedFilterOptionException(
                sprintf('LikeMode "%s" is not supported by SqliteLikeHandler.', $modeName),
                'sqlite',
            );
        }

        $pattern = $this->prepareValue($filter->value, $filter->mode);

        if ($filter->caseSensitive === true) {
            throw new NotSupportedFilterOptionException(optionName: 'caseSensitive', driverType: 'SQLite');
        }

        return [$filter->field, 'like', $pattern];
    }
}
