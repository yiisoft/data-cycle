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
        $allowedModes = [LikeMode::Contains, LikeMode::StartsWith, LikeMode::EndsWith];

        /** @var Like $filter */
        $modeName = $filter->mode->name;

        if (!in_array($filter->mode, $allowedModes, true)) {
            throw new NotSupportedFilterOptionException(
                sprintf('LikeMode "%s" is not supported by SqliteLikeHandler.', $modeName),
                'sqlite',
            );
        }
        
        // The above escaping replacements will be used to build the pattern
        // in the event of escape characters (% or _) being found in the $filter->value
        // Sqlite does not have the ESCAPE command available
        $pattern = $this->prepareValue($filter->value, $filter->mode);

        if ($filter->caseSensitive === true) {
            throw new NotSupportedFilterOptionException(optionName: 'caseSensitive', driverType: 'SQLite');
        }

        return [$filter->field, 'like', $pattern];
    }
}
