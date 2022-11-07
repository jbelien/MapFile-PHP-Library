<?php

declare(strict_types=1);

namespace Tests\Parse;

use Doctrine\Common\Collections\ArrayCollection;
use MapFile\Parser\Label;
use Tests\ParseTest;

final class LabelTest extends ParseTest
{
    public function test(): void
    {
        $parser = new Label($this->stub);
        $label = $parser->parse();

        self::assertSame('CENTER', $label->align);
        self::assertSame('AUTO', $label->angle);
        self::assertSame(10, $label->buffer);
        self::assertSame([255, 0, 0], $label->color);
        self::assertSame('([POPULATION] > 50000 AND \'[LANGUAGE]\' eq \'FRENCH\')', $label->expression);
        self::assertSame('dejavu', $label->font);
        self::assertSame(true, $label->force);
        self::assertSame(25, $label->maxlength);
        self::assertSame(45.0, $label->maxoverlapangle);
        self::assertSame(10000.0, $label->maxscaledenom);
        self::assertSame(10.0, $label->maxsize);
        self::assertSame(50, $label->mindistance);
        self::assertSame(5, $label->minfeaturesize);
        self::assertSame(1000.0, $label->minscaledenom);
        self::assertSame(1.0, $label->minsize);
        self::assertSame([5, 5], $label->offset);
        self::assertSame([0, 255, 0], $label->outlinecolor);
        self::assertSame(1, $label->outlinewidth);
        self::assertSame(false, $label->partials);
        self::assertSame('AUTO', $label->position);
        self::assertSame(10, $label->priority);
        self::assertSame(5, $label->repeatdistance);
        self::assertSame([0, 0, 255], $label->shadowcolor);
        self::assertSame([3, 3], $label->shadowsize);
        self::assertSame('LARGE', $label->size);
        self::assertInstanceOf(ArrayCollection::class, $label->style);
        self::assertCount(2, $label->style);
        self::assertSame('labelcenter', $label->style[0]->geomtransform);
        self::assertSame([153, 153, 153], $label->style[0]->color);
        self::assertSame('labelpoly', $label->style[1]->geomtransform);
        self::assertSame([255, 0, 0], $label->style[1]->color);
        self::assertSame('[FIRSTNAME] [LASTNAME]', $label->text);
        self::assertSame('TRUETYPE', $label->type);
        self::assertSame('-', $label->wrap);
    }
}
