<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Composite as CompositeObject;
use MapFile\Writer\Composite;
use Tests\WriteTest;

final class CompositeTest extends WriteTest
{
    public function test(): void
    {
        $cluster = new CompositeObject();
        $cluster->opacity = 100;
        $cluster->compop = 'darken';

        $writer = new Composite($this->path);
        $writer->writeBlock($cluster);
        $result = $writer->save();

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
