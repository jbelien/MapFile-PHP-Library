<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Grid as GridObject;
use MapFile\Writer\Grid;
use Tests\WriteTest;

final class GridTest extends WriteTest
{
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
        $writer->writeBlock($grid);
        $result = $writer->save();

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
