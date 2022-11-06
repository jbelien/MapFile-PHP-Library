<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Feature as FeatureObject;
use MapFile\Writer\Feature;
use Tests\WriteTest;

final class FeatureTest extends WriteTest
{
    protected string $path = 'tests/.temp/FEATURE.test';
    protected string $stub = 'tests/stubs/FEATURE';

    public function test(): void
    {
        $feature = new FeatureObject();
        $feature->items = 'value1;value2;value3';
        $feature->points = [[1, 1], [50, 50], [1, 50], [1, 1]];
        $feature->text = 'test';
        $feature->wkt = 'POLYGON((1 1, 50 50, 1 50, 1 1))';

        $writer = new Feature($this->path);
        $writer->write($feature);
        $result = $writer->save();

        $this->assertTrue($result);
        $this->assertFileEquals($this->stub, $this->path);
    }
}
