<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\QueryMap as QueryMapObject;
use MapFile\Model\Style;
use MapFile\Writer\QueryMap;
use Tests\WriteTest;

final class QueryMapTest extends WriteTest
{
    protected string $path = 'tests/.temp/QUERYMAP.test';
    protected string $stub = 'tests/stubs/QUERYMAP';

    public function test(): void
    {
        $querymap = new QueryMapObject();
        $querymap->color = [0, 255, 0];
        $querymap->size = [100, 100];
        $querymap->status = 'ON';
        $querymap->style = 'HILITE';

        $writer = new QueryMap($this->path);
        $writer->write($querymap);
        $result = $writer->save();

        $this->assertTrue($result);
        $this->assertFileEquals($this->stub, $this->path);
    }
}
