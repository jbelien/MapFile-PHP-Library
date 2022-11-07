<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\QueryMap;
use Tests\ParseTest;

final class QueryMapTest extends ParseTest
{
    public function test(): void
    {
        $parser = new QueryMap($this->stub);
        $querymap = $parser->parse();

        $this->assertSame([0, 255, 0], $querymap->color);
        $this->assertSame([100, 100], $querymap->size);
        $this->assertSame('ON', $querymap->status);
        $this->assertSame('HILITE', $querymap->style);
    }
}
