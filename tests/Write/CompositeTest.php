<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Composite;
use MapFile\Writer\Composite as Writer;
use Tests\WriteTest;

final class CompositeTest extends WriteTest
{
    public function test(): void
    {
        $composite = new Composite();
        $composite->opacity = 100;
        $composite->compop = 'darken';

        $result = (new Writer($composite))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
