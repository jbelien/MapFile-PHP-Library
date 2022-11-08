<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Feature;
use MapFile\Writer\Feature as Writer;
use Tests\WriteTest;

final class FeatureTest extends WriteTest
{
    public function test(): void
    {
        $feature = new Feature();
        $feature->items = 'value1;value2;value3';
        $feature->points = [[1, 1], [50, 50], [1, 50], [1, 1]];
        $feature->text = 'test';
        $feature->wkt = 'POLYGON((1 1, 50 50, 1 50, 1 1))';

        $result = (new Writer($feature))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
