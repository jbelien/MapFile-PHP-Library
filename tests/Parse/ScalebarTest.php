<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Scalebar;
use Tests\ParseTest;

final class ScalebarTest extends ParseTest
{
    public function test(): void
    {
        $parser = new Scalebar($this->stub);
        $scalebar = $parser->parse();

        self::assertSame('CENTER', $scalebar->align);
        self::assertSame([255, 255, 255], $scalebar->backgroundcolor);
        self::assertSame([0, 0, 0], $scalebar->color);
        self::assertSame([0, 255, 0], $scalebar->imagecolor);
        self::assertSame(4, $scalebar->intervals);
        self::assertNotNull($scalebar->label);
        self::assertSame([80, 80, 80], $scalebar->label->color);
        self::assertSame([5, 5], $scalebar->offset);
        self::assertSame([0, 0, 0], $scalebar->outlinecolor);
        self::assertSame('UR', $scalebar->position);
        self::assertSame(true, $scalebar->postlabelcache);
        self::assertSame([50, 50], $scalebar->size);
        self::assertSame('EMBED', $scalebar->status);
        self::assertSame(0, $scalebar->style);
        self::assertSame('METERS', $scalebar->units);
    }
}
