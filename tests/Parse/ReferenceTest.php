<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Reference;
use Tests\ParseTest;

final class ReferenceTest extends ParseTest
{
    public function test(): void
    {
        $parser = new Reference($this->stub);
        $reference = $parser->parseBlock();

        self::assertSame([255, 0, 0], $reference->color);
        self::assertSame([0.0, 0.0, 100.0, 100.0], $reference->extent);
        self::assertSame('image.png', $reference->image);
        self::assertSame(0, $reference->marker);
        self::assertSame(10, $reference->markersize);
        self::assertSame(1, $reference->minboxsize);
        self::assertSame(5, $reference->maxboxsize);
        self::assertSame([0, 0, 255], $reference->outlinecolor);
        self::assertSame([10, 10], $reference->size);
        self::assertSame('ON', $reference->status);
    }
}
