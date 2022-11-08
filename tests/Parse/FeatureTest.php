<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Feature as Parser;
use Tests\ParseTest;

final class FeatureTest extends ParseTest
{
    public function test(): void
    {
        $feature = (new Parser())->parse($this->stub);

        self::assertSame('value1;value2;value3', $feature->items);
        self::assertSame([[1.0, 1.0], [50.0, 50.0], [1.0, 50.0], [1.0, 1.0]], $feature->points);
        self::assertSame('test', $feature->text);
        self::assertSame('POLYGON((1 1, 50 50, 1 50, 1 1))', $feature->wkt);
    }
}
