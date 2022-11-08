<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Label;
use MapFile\Model\Style;
use MapFile\Writer\Label as Writer;
use Tests\WriteTest;

final class LabelTest extends WriteTest
{
    public function test(): void
    {
        $label = new Label();
        $label->align = 'CENTER';
        $label->angle = 'AUTO';
        $label->buffer = 10;
        $label->color = [255, 0, 0];
        $label->expression = '([POPULATION] > 50000 AND \'[LANGUAGE]\' eq \'FRENCH\')';
        $label->font = 'dejavu';
        $label->force = true;
        $label->maxlength = 25;
        $label->maxoverlapangle = 45;
        $label->maxscaledenom = 10000;
        $label->maxsize = 10;
        $label->mindistance = 50;
        $label->minfeaturesize = 5;
        $label->minscaledenom = 1000;
        $label->minsize = 1;
        $label->offset = [5, 5];
        $label->outlinecolor = [0, 255, 0];
        $label->outlinewidth = 1;
        $label->partials = false;
        $label->position = 'AUTO';
        $label->priority = 10;
        $label->repeatdistance = 5;
        $label->shadowcolor = [0, 0, 255];
        $label->shadowsize = [3, 3];
        $label->size = 'LARGE';
        $label->text = '[FIRSTNAME] [LASTNAME]';
        $label->type = 'TRUETYPE';
        $label->wrap = '-';

        $style = new Style();
        $style->color = [153, 153, 153];
        $style->geomtransform = 'labelcenter';
        $label->style[] = $style;

        $style = new Style();
        $style->color = [255, 0, 0];
        $style->geomtransform = 'labelpoly';
        $label->style[] = $style;

        $result = (new Writer($label))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
