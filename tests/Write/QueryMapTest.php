<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\QueryMap;
use MapFile\Writer\QueryMap as Writer;
use Tests\WriteTest;

final class QueryMapTest extends WriteTest
{
    public function test(): void
    {
        $querymap = new QueryMap();
        $querymap->color = [0, 255, 0];
        $querymap->size = [100, 100];
        $querymap->status = 'ON';
        $querymap->style = 'HILITE';

        $result = (new Writer($querymap))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
