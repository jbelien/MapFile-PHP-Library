<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Style;
use MapFile\Writer\Style as Writer;
use Tests\WriteTest;

final class StyleTest extends WriteTest
{
    public function test(): void
    {
        $style = new Style();
        $style->angle = 45;
        $style->color = [255, 0, 0];
        $style->colorrange = [0, 0, 0, 255, 255, 0];
        $style->datarange = [0, 100];
        $style->gap = 50;
        $style->geomtransform = 'centroid';
        $style->initialgap = 20;
        $style->linecap = 'ROUND';
        $style->linejoin = 'ROUND';
        $style->linejoinmaxsize = 3;
        $style->maxscaledenom = 10000;
        $style->maxwidth = 32;
        $style->minscaledenom = 1000;
        $style->minwidth = 0;
        $style->offset = [5, 5];
        $style->opacity = 100;
        $style->outlinecolor = [0, 255, 0];
        $style->outlinewidth = 3;
        $style->pattern = [[5.0, 5.0]];
        $style->polaroffset = [20, 40];
        $style->rangeitem = 'foobar';
        $style->size = 10;
        $style->symbol = 0;
        $style->width = 1;

        $result = (new Writer($style))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
