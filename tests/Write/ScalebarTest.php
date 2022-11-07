<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Label;
use MapFile\Model\Scalebar as ScalebarObject;
use MapFile\Writer\Scalebar;
use Tests\WriteTest;

final class ScalebarTest extends WriteTest
{
    public function test(): void
    {
        $scalebar = new ScalebarObject();
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

        $writer = new Scalebar($this->path);
        $writer->write($scalebar);
        $result = $writer->save();

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
