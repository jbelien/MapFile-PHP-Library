<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Scalebar;
use PHPUnit\Framework\TestCase;

final class ScalebarTest extends TestCase
{
    protected string $stub = 'tests/stubs/SCALEBAR';

    public function test(): void
    {
        $parser = new Scalebar($this->stub);
        $scalebar = $parser->parse();

        $this->assertSame('CENTER', $scalebar->align);
        $this->assertSame([255, 255, 255], $scalebar->backgroundcolor);
        $this->assertSame([0, 0, 0], $scalebar->color);
        $this->assertSame([0, 255, 0], $scalebar->imagecolor);
        $this->assertSame(4, $scalebar->intervals);
        $this->assertSame([80, 80, 80], $scalebar->label->color);
        $this->assertSame([5, 5], $scalebar->offset);
        $this->assertSame([0, 0, 0], $scalebar->outlinecolor);
        $this->assertSame('UR', $scalebar->position);
        $this->assertSame(true, $scalebar->postlabelcache);
        $this->assertSame([50, 50], $scalebar->size);
        $this->assertSame('EMBED', $scalebar->status);
        $this->assertSame(0, $scalebar->style);
        $this->assertSame('METERS', $scalebar->units);
    }
}
