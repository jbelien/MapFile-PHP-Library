<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Grid;
use Tests\ParseTest;

final class GridTest extends ParseTest
{
    public function test(): void
    {
        $parser = new Grid($this->stub);
        $grid = $parser->parse();

        $this->assertSame('DD', $grid->labelformat);
        $this->assertSame(1.0, $grid->minarcs);
        $this->assertSame(2.0, $grid->maxarcs);
        $this->assertSame(1.0, $grid->mininterval);
        $this->assertSame(2.0, $grid->maxinterval);
        $this->assertSame(1.0, $grid->minsubdivide);
        $this->assertSame(256.0, $grid->maxsubdivide);
    }
}
