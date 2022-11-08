<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Label;
use MapFile\Model\Scalebar;
use MapFile\Writer\Scalebar as Writer;
use Tests\WriteTest;

final class ScalebarTest extends WriteTest
{
    public function test(): void
    {
        $scalebar = new Scalebar();
        $scalebar->align = 'CENTER';
        $scalebar->backgroundcolor = [255, 255, 255];
        $scalebar->color = [0, 0, 0];
        $scalebar->imagecolor = [0, 255, 0];
        $scalebar->intervals = 4;
        $scalebar->offset = [5, 5];
        $scalebar->outlinecolor = [0, 0, 0];
        $scalebar->position = 'UR';
        $scalebar->postlabelcache = true;
        $scalebar->size = [50, 50];
        $scalebar->status = 'EMBED';
        $scalebar->style = 0;
        $scalebar->units = 'METERS';

        $scalebar->label = new Label();
        $scalebar->label->color = [80, 80, 80];

        $result = (new Writer($scalebar))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
