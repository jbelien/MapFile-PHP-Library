<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Feature;
use Tests\ParseTest;

final class FeatureTest extends ParseTest
{
    public function test(): void
    {
        $parser = new Feature($this->stub);
        $feature = $parser->parse();

        $this->assertSame('value1;value2;value3', $feature->items);
        $this->assertSame([[1.0, 1.0], [50.0, 50.0], [1.0, 50.0], [1.0, 1.0]], $feature->points);
        $this->assertSame('test', $feature->text);
        $this->assertSame('POLYGON((1 1, 50 50, 1 50, 1 1))', $feature->wkt);
    }
}
