<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Reference;
use MapFile\Writer\Reference as Writer;
use Tests\WriteTest;

final class ReferenceTest extends WriteTest
{
    public function test(): void
    {
        $reference = new Reference();
        $reference->color = [255, 0, 0];
        $reference->extent = [0, 0, 100, 100];
        $reference->image = 'image.png';
        $reference->marker = 0;
        $reference->markersize = 10;
        $reference->minboxsize = 1;
        $reference->maxboxsize = 5;
        $reference->outlinecolor = [0, 0, 255];
        $reference->size = [10, 10];
        $reference->status = 'ON';

        $result = (new Writer($reference))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
