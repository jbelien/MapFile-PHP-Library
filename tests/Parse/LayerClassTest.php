<?php

declare(strict_types=1);

namespace Tests\Parse;

use Doctrine\Common\Collections\ArrayCollection;
use MapFile\Model\Label;
use MapFile\Model\Leader;
use MapFile\Model\Style;
use MapFile\Parser\LayerClass;
use Tests\ParseTest;

final class LayerClassTest extends ParseTest
{
    public function test(): void
    {
        $parser = new LayerClass($this->stub);
        $layerclass = $parser->parse();

        self::assertSame('ON', $layerclass->debug);
        self::assertSame('([POPULATION] > 50000 AND \'[LANGUAGE]\' eq \'FRENCH\')', $layerclass->expression);
        self::assertSame('group1', $layerclass->group);
        self::assertSame('legend.png', $layerclass->keyimage);
        self::assertInstanceOf(ArrayCollection::class, $layerclass->label);
        self::assertCount(1, $layerclass->label);
        self::assertSame([150, 150, 150], $layerclass->label[0]->color);
        self::assertInstanceOf(Leader::class, $layerclass->leader);
        self::assertSame(30, $layerclass->leader->maxdistance);
        self::assertSame(10000.0, $layerclass->maxscaledenom);
        self::assertSame(1000.0, $layerclass->minscaledenom);
        self::assertSame('name1', $layerclass->name);
        self::assertSame('ON', $layerclass->status);
        self::assertInstanceOf(ArrayCollection::class, $layerclass->style);
        self::assertCount(1, $layerclass->style);
        self::assertSame([80, 80, 80], $layerclass->style[0]->color);
        self::assertSame('template.html', $layerclass->template);
        self::assertSame('[FIRSTNAME] [LASTNAME]', $layerclass->text);
        self::assertSame(['firstname' => '^[a-zA-Z\-]+$'], $layerclass->validation);
    }
}
