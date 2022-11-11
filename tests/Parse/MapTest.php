<?php

declare(strict_types=1);

namespace Tests\Parse;

use Doctrine\Common\Collections\ArrayCollection;
use MapFile\Model\Layer;
use MapFile\Model\Legend;
use MapFile\Model\OutputFormat;
use MapFile\Model\QueryMap;
use MapFile\Model\Reference;
use MapFile\Model\Scalebar;
use MapFile\Model\Symbol;
use MapFile\Model\Web;
use MapFile\Parser\Map as Parser;
use Tests\ParseTest;

final class MapTest extends ParseTest
{
    public function test(): void
    {
        $map = (new Parser())->parse($this->stub);

        self::assertSame(45.0, $map->angle);
        self::assertSame(['ON_MISSING_DATA' => 'FAIL', 'PROJ_LIB' => '/usr/local/share/proj/'], $map->config);
        self::assertSame(5, $map->debug);
        self::assertSame(72, $map->defresolution);
        self::assertSame([0.0, 0.0, 150000.0, 150000.0], $map->extent);
        self::assertSame('fontset', $map->fontset);
        self::assertSame([0, 255, 0], $map->imagecolor);
        self::assertSame('PNG', $map->imagetype);
        self::assertInstanceOf(ArrayCollection::class, $map->layer);
        self::assertCount(1, $map->layer);
        self::assertInstanceOf(Layer::class, $map->layer[0]);
        self::assertSame('my-layer', $map->layer[0]->name);
        self::assertInstanceOf(Legend::class, $map->legend);
        self::assertSame([255, 0, 0], $map->legend->imagecolor);
        self::assertSame(4096, $map->maxsize);
        self::assertSame('my-map', $map->name);
        self::assertInstanceOf(ArrayCollection::class, $map->outputformat);
        self::assertCount(1, $map->outputformat);
        self::assertInstanceOf(OutputFormat::class, $map->outputformat[0]);
        self::assertSame('image/png; mode=8bit', $map->outputformat[0]->mimetype);
        self::assertSame('epsg:4326', $map->projection);
        self::assertInstanceOf(QueryMap::class, $map->querymap);
        self::assertSame([0, 255, 0], $map->querymap->color);
        self::assertInstanceOf(Reference::class, $map->reference);
        self::assertSame([255, 0, 0], $map->reference->color);
        self::assertSame(72, $map->resolution);
        self::assertSame(24000.0, $map->scaledenom);
        self::assertInstanceOf(Scalebar::class, $map->scalebar);
        self::assertSame([0, 0, 0], $map->scalebar->color);
        self::assertSame('./data', $map->shapepath);
        self::assertSame([1000, 1000], $map->size);
        self::assertSame('ON', $map->status);
        self::assertInstanceOf(ArrayCollection::class, $map->symbol);
        self::assertCount(1, $map->symbol);
        self::assertInstanceOf(Symbol::class, $map->symbol[0]);
        self::assertSame('right-arrow', $map->symbol[0]->name);
        self::assertSame('symbolset', $map->symbolset);
        self::assertSame('METERS', $map->units);
        self::assertInstanceOf(Web::class, $map->web);
        self::assertSame('text/html', $map->web->browseformat);
    }
}
