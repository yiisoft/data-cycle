<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader;

abstract class BaseReaderTestCase extends \Yiisoft\Data\Tests\Common\Reader\BaseReaderTestCase
{
    protected function assertFixtures(array $expectedFixtureIndexes, array $actualFixtures): void
    {
        $processedActualFixtures = [];
        foreach ($actualFixtures as $fixture) {
            if (is_object($fixture)) {
                $fixture = json_decode(json_encode($fixture), associative: true);
            }

            unset($fixture['id']);
            $fixture['number'] = (int) $fixture['number'];
            $fixture['balance'] = (float) $fixture['balance'];

            $processedActualFixtures[$fixture['number'] - 1] = $fixture;
        }

        parent::assertFixtures($expectedFixtureIndexes, $processedActualFixtures);
    }
}
