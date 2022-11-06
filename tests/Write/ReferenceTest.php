<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Reference as ReferenceObject;
use MapFile\Writer\Reference;
use Tests\WriteTest;

final class ReferenceTest extends WriteTest
{
    protected string $path = 'tests/.temp/REFERENCE.test';
    protected string $stub = 'tests/stubs/REFERENCE';

    public function test(): void
    {
        $reference = new ReferenceObject();
        $reference->color = [255, 0, 0];
        $reference->extent = [0, 0, 100, 100];
        $reference->image = 'image.png';
        $reference->marker = 0;
        $reference->markersize = 10;
        $reference->minboxsize = 1;
        $reference->maxboxsize = 5;
        $reference->outlinecolor = [0, 0, 255];
        $reference->size = [10, 10];
        $reference->status ='ON';

        $writer = new Reference($this->path);
        $writer->write($reference);
        $result = $writer->save();

        $this->assertTrue($result);
        $this->assertFileEquals($this->stub, $this->path);
    }
}
