<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Symbol as SymbolObject;
use MapFile\Writer\Symbol;
use Tests\WriteTest;

final class SymbolTest extends WriteTest
{
    public function test(): void
    {
        $symbol = new SymbolObject();
        $symbol->anchorpoint = [5, 5];
        $symbol->antialias = true;
        $symbol->character = '&#10140;';
        $symbol->filled = true;
        $symbol->font = 'dejavu';
        $symbol->image = 'image.png';
        $symbol->name = 'right-arrow';
        $symbol->points = [[1, 1], [50, 50], [1, 50], [1, 1]];
        $symbol->transparent = 0;
        $symbol->type = 'TRUETYPE';

        $writer = new Symbol($this->path);
        $writer->write($symbol);
        $result = $writer->save();

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
