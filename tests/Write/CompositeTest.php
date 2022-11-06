<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Composite as CompositeObject;
use MapFile\Writer\Composite;
use Tests\WriteTest;

final class CompositeTest extends WriteTest
{
    protected string $path = 'tests/.temp/COMPOSITE.test';
    protected string $stub = 'tests/stubs/COMPOSITE';

    public function test(): void
    {
        $cluster = new CompositeObject();
        $cluster->opacity = 100;
        $cluster->compop = 'darken';

        $writer = new Composite($this->path);
        $writer->write($cluster);
        $result = $writer->save();

        $this->assertTrue($result);
        $this->assertFileEquals($this->stub, $this->path);
    }
}
