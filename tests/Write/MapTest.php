<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Layer;
use MapFile\Model\Legend;
use MapFile\Model\Map;
use MapFile\Model\OutputFormat;
use MapFile\Model\QueryMap;
use MapFile\Model\Reference;
use MapFile\Model\Scalebar;
use MapFile\Model\Symbol;
use MapFile\Model\Web;
use MapFile\Writer\Map as Writer;
use Tests\WriteTest;

final class MapTest extends WriteTest
{
    public function test(): void
    {
        $map = new Map();
        $map->angle = 45.0;
        $map->config = ['ON_MISSING_DATA' => 'FAIL', 'PROJ_LIB' => '/usr/local/share/proj/'];
        $map->debug = 5;
        $map->defresolution = 72;
        $map->extent = [0.0, 0.0, 150000.0, 150000.0];
        $map->fontset = 'fontset';
        $map->imagecolor = [0, 255, 0];
        $map->imagetype = 'PNG';
        $map->maxsize = 4096;
        $map->name = 'my-map';
        $map->projection = 'epsg:4326';
        $map->resolution = 72;
        $map->scaledenom = 24000.0;
        $map->shapepath = './data';
        $map->size = [1000, 1000];
        $map->status = 'ON';
        $map->symbolset = 'symbolset';
        $map->units = 'METERS';

        $layer = new Layer();
        $layer->name = 'my-layer';
        $map->layer->add($layer);

        $map->legend = new Legend();
        $map->legend->imagecolor = [255, 0, 0];

        $outputformat = new OutputFormat();
        $outputformat->mimetype = 'image/png; mode=8bit';
        $map->outputformat->add($outputformat);

        $map->querymap = new QueryMap();
        $map->querymap->color = [0, 255, 0];

        $map->reference = new Reference();
        $map->reference->color = [255, 0, 0];

        $map->scalebar = new Scalebar();
        $map->scalebar->color = [0, 0, 0];

        $symbol = new Symbol();
        $symbol->name = 'right-arrow';
        $map->symbol->add($symbol);

        $map->web = new Web();
        $map->web->browseformat = 'text/html';

        $result = (new Writer($map))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
