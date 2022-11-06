<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Grid as GridObject;
use MapFile\Writer\Grid;
use Tests\WriteTest;

final class GridTest extends WriteTest
{
    protected string $path = 'tests/.temp/GRID.test';
    protected string $stub = 'tests/stubs/GRID';

    public function test(): void
    {
        $grid = new GridObject();
        $grid->labelformat = 'DD';
        $grid->minarcs = 1;
        $grid->maxarcs = 2;
        $grid->mininterval = 1;
        $grid->maxinterval = 2;
        $grid->minsubdivide = 1;
        $grid->maxsubdivide = 256;

        $writer = new Grid($this->path);
        $writer->write($grid);
        $result = $writer->save();

        $this->assertTrue($result);
        $this->assertFileEquals($this->stub, $this->path);
    }
}
