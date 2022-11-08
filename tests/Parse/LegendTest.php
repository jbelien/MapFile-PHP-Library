<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Model\Label;
use MapFile\Parser\Legend as Parser;
use Tests\ParseTest;

final class LegendTest extends ParseTest
{
    public function test(): void
    {
        $legend = (new Parser())->parse($this->stub);

        self::assertSame([255, 0, 0], $legend->imagecolor);
        self::assertSame([20, 10], $legend->keysize);
        self::assertSame([5, 5], $legend->keyspacing);
        self::assertInstanceOf(Label::class, $legend->label);
        self::assertSame([80, 80, 80], $legend->label->color);
        self::assertSame([0, 255, 0], $legend->outlinecolor);
        self::assertSame('UC', $legend->position);
        self::assertSame(false, $legend->postlabelcache);
        self::assertSame('EMBED', $legend->status);
        self::assertSame('template.html', $legend->template);
    }
}
