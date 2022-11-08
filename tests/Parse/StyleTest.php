<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Style as Parser;
use Tests\ParseTest;

final class StyleTest extends ParseTest
{
    public function test(): void
    {
        $style = (new Parser())->parse($this->stub);

        self::assertSame(45.0, $style->angle);
        self::assertSame([255, 0, 0], $style->color);
        self::assertSame([0, 0, 0, 255, 255, 0], $style->colorrange);
        self::assertSame([0.0, 100.0], $style->datarange);
        self::assertSame(50.0, $style->gap);
        self::assertSame('centroid', $style->geomtransform);
        self::assertSame(20.0, $style->initialgap);
        self::assertSame('ROUND', $style->linecap);
        self::assertSame('ROUND', $style->linejoin);
        self::assertSame(3, $style->linejoinmaxsize);
        self::assertSame(10000.0, $style->maxscaledenom);
        self::assertSame(32.0, $style->maxwidth);
        self::assertSame(1000.0, $style->minscaledenom);
        self::assertSame(0.0, $style->minwidth);
        self::assertSame([5, 5], $style->offset);
        self::assertSame(100, $style->opacity);
        self::assertSame([0, 255, 0], $style->outlinecolor);
        self::assertSame(3, $style->outlinewidth);
        self::assertSame([[5.0, 5.0]], $style->pattern);
        self::assertSame([20.0, 40.0], $style->polaroffset);
        self::assertSame('foobar', $style->rangeitem);
        self::assertSame(10.0, $style->size);
        self::assertSame(0, $style->symbol);
        self::assertSame(1.0, $style->width);
    }
}
