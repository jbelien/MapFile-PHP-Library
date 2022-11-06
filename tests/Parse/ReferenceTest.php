<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Reference;
use PHPUnit\Framework\TestCase;

final class ReferenceTest extends TestCase
{
    protected string $stub = 'tests/stubs/REFERENCE';

    public function test(): void
    {
        $parser = new Reference($this->stub);
        $reference = $parser->parse();

        $this->assertSame([255, 0, 0], $reference->color);
        $this->assertSame([0.0, 0.0, 100.0, 100.0], $reference->extent);
        $this->assertSame('image.png', $reference->image);
        $this->assertSame(0, $reference->marker);
        $this->assertSame(10, $reference->markersize);
        $this->assertSame(1, $reference->minboxsize);
        $this->assertSame(5, $reference->maxboxsize);
        $this->assertSame([0, 0, 255], $reference->outlinecolor);
        $this->assertSame([10, 10], $reference->size);
        $this->assertSame('ON', $reference->status);
    }
}
