<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Grid as Parser;
use Tests\ParseTest;

final class GridTest extends ParseTest
{
    public function test(): void
    {
        $grid = (new Parser())->parse($this->stub);

        self::assertSame('DD', $grid->labelformat);
        self::assertSame(1.0, $grid->minarcs);
        self::assertSame(2.0, $grid->maxarcs);
        self::assertSame(1.0, $grid->mininterval);
        self::assertSame(2.0, $grid->maxinterval);
        self::assertSame(1.0, $grid->minsubdivide);
        self::assertSame(256.0, $grid->maxsubdivide);
    }
}
