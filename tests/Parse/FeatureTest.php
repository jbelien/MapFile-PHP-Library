<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Feature;
use PHPUnit\Framework\TestCase;

final class FeatureTest extends TestCase
{
    protected string $stub = 'tests/stubs/FEATURE';

    public function test(): void
    {
        $parser = new Feature($this->stub);
        $feature = $parser->parse();

        $this->assertEquals('value1;value2;value3', $feature->items);
        $this->assertEquals([[1, 1], [50, 50], [1, 50], [1, 1]], $feature->points);
        $this->assertEquals('test', $feature->text);
        $this->assertEquals('POLYGON((1 1, 50 50, 1 50, 1 1))', $feature->wkt);
    }
}
