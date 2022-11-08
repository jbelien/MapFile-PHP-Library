<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Symbol as Parser;
use Tests\ParseTest;

final class SymbolTest extends ParseTest
{
    public function test(): void
    {
        $symbol = (new Parser())->parse($this->stub);

        self::assertSame([5.0, 5.0], $symbol->anchorpoint);
        self::assertSame(true, $symbol->antialias);
        self::assertSame('&#10140;', $symbol->character);
        self::assertSame(true, $symbol->filled);
        self::assertSame('dejavu', $symbol->font);
        self::assertSame('image.png', $symbol->image);
        self::assertSame('right-arrow', $symbol->name);
        self::assertSame([[1.0, 1.0], [50.0, 50.0], [1.0, 50.0], [1.0, 1.0]], $symbol->points);
        self::assertSame(0, $symbol->transparent);
        self::assertSame('TRUETYPE', $symbol->type);
    }
}
