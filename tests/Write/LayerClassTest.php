<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Label;
use MapFile\Model\LayerClass;
use MapFile\Model\Leader;
use MapFile\Model\Style;
use MapFile\Writer\LayerClass as Writer;
use Tests\WriteTest;

final class LayerClassTest extends WriteTest
{
    public function test(): void
    {
        $layerclass = new LayerClass();
        $layerclass->debug = 'ON';
        $layerclass->expression = '([POPULATION] > 50000 AND \'[LANGUAGE]\' eq \'FRENCH\')';
        $layerclass->group = 'group1';
        $layerclass->keyimage = 'legend.png';
        $layerclass->maxscaledenom = 10000;
        $layerclass->minscaledenom = 1000;
        $layerclass->name = 'name1';
        $layerclass->status = 'ON';
        $layerclass->template = 'template.html';
        $layerclass->text = '[FIRSTNAME] [LASTNAME]';
        $layerclass->validation = ['firstname' => '^[a-zA-Z\-]+$'];

        $label = new Label();
        $label->color = [150, 150, 150];
        $layerclass->label->add($label);

        $layerclass->leader = new Leader();
        $layerclass->leader->maxdistance = 30;

        $style = new Style();
        $style->color = [80, 80, 80];
        $layerclass->style->add($style);

        $result = (new Writer($layerclass))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
