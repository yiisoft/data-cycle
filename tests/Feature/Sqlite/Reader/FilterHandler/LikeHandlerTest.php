<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\LikeHandlerTest as BaseLikeHandlerTest;

final class LikeHandlerTest extends BaseLikeHandlerTest
{
    public const DRIVER = 'sqlite';

    public static function dataBase(): array
    {
        $data = parent::dataBase();
        /** @link https://www.sqlite.org/lang_expr.html#the_like_glob_regexp_match_and_extract_operators */
        $data['case does not match'] = ['email', 'SEED@%', [2]];

        return $data;
    }
}
