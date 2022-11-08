<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Feature as FeatureObject;
use MapFile\Writer\Feature;
use Tests\WriteTest;

final class FeatureTest extends WriteTest
{
    public function test(): void
    {
        $feature = new FeatureObject();
        $feature->items = 'value1;value2;value3';
        $feature->points = [[1, 1], [50, 50], [1, 50], [1, 1]];
        $feature->text = 'test';
        $feature->wkt = 'POLYGON((1 1, 50 50, 1 50, 1 1))';

        $writer = new Feature();
        $writer->writeBlock($feature);
        $result = $writer->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
