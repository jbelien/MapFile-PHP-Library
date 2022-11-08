<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Label;
use MapFile\Model\Legend;
use MapFile\Writer\Legend as Writer;
use Tests\WriteTest;

final class LegendTest extends WriteTest
{
    public function test(): void
    {
        $legend = new Legend();
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

        $result = (new Writer($legend))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
