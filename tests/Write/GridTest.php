<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Grid;
use MapFile\Writer\Grid as Writer;
use Tests\WriteTest;

final class GridTest extends WriteTest
{
    public function test(): void
    {
        $grid = new Grid();
        $grid->labelformat = 'DD';
        $grid->minarcs = 1;
        $grid->maxarcs = 2;
        $grid->mininterval = 1;
        $grid->maxinterval = 2;
        $grid->minsubdivide = 1;
        $grid->maxsubdivide = 256;

        $result = (new Writer($grid))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
