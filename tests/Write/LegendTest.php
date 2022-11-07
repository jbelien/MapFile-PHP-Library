<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Label;
use MapFile\Model\Legend as LegendObject;
use MapFile\Writer\Legend;
use Tests\WriteTest;

final class LegendTest extends WriteTest
{
    public function test(): void
    {
        $legend = new LegendObject();
        $legend->imagecolor = [255, 0, 0];
        $legend->keysize = [20, 10];
        $legend->keyspacing = [5, 5];
        $legend->outlinecolor = [0, 255, 0];
        $legend->position = 'UC';
        $legend->postlabelcache = false;
        $legend->status = 'EMBED';
        $legend->template = 'template.html';

        $legend->label = new Label();
        $legend->label->color = [80, 80, 80];

        $writer = new Legend($this->path);
        $writer->write($legend);
        $result = $writer->save();

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
