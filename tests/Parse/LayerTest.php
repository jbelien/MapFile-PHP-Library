<?php

declare(strict_types=1);

namespace Tests\Parse;

use Doctrine\Common\Collections\ArrayCollection;
use MapFile\Model\Cluster;
use MapFile\Model\Composite;
use MapFile\Model\Feature;
use MapFile\Model\Grid;
use MapFile\Model\Join;
use MapFile\Model\LayerClass;
use MapFile\Model\ScaleToken;
use MapFile\Parser\Layer as Parser;
use Tests\ParseTest;

final class LayerTest extends ParseTest
{
    public function test(): void
    {
        $layer = (new Parser())->parse($this->stub);

        self::assertInstanceOf(ArrayCollection::class, $layer->class);
        self::assertCount(1, $layer->class);
        self::assertInstanceOf(LayerClass::class, $layer->class[0]);
        self::assertSame('name1', $layer->class[0]->name);
        self::assertSame('group1', $layer->class[0]->group);
        self::assertSame('group1', $layer->classgroup);
        self::assertInstanceOf(Cluster::class, $layer->cluster);
        self::assertSame(20.0, $layer->cluster->maxdistance);
        self::assertSame('ellipse', $layer->cluster->region);
        self::assertInstanceOf(ArrayCollection::class, $layer->composite);
        self::assertCount(1, $layer->composite);
        self::assertInstanceOf(Composite::class, $layer->composite[0]);
        self::assertSame(70, $layer->composite[0]->opacity);
        self::assertSame('column1', $layer->classitem);
        self::assertSame('lakes.db', $layer->connection);
        self::assertSame('OGR', $layer->connectiontype);
        self::assertSame('lakes', $layer->data);
        self::assertSame(0, $layer->debug);
        self::assertSame('UTF-8', $layer->encoding);
        self::assertSame([0.0, 0.0, 150000.0, 150000.0], $layer->extent);
        self::assertInstanceOf(ArrayCollection::class, $layer->feature);
        self::assertCount(1, $layer->feature);
        self::assertInstanceOf(Feature::class, $layer->feature[0]);
        self::assertSame('POINT(2000 2500)', $layer->feature[0]->wkt);
        self::assertSame('("[type]"=\'road\' and [size]<2)', $layer->filter);
        self::assertSame('column1', $layer->filteritem);
        self::assertSame('footer.html', $layer->footer);
        self::assertSame('(simplify((centerline([shape])), 10000))', $layer->geomtransform);
        self::assertInstanceOf(Grid::class, $layer->grid);
        self::assertSame('DD', $layer->grid->labelformat);
        self::assertSame('group', $layer->group);
        self::assertSame('header.html', $layer->header);
        self::assertInstanceOf(ArrayCollection::class, $layer->join);
        self::assertCount(1, $layer->join);
        self::assertInstanceOf(Join::class, $layer->join[0]);
        self::assertSame('test', $layer->join[0]->name);
        self::assertSame('../data/lookup.dbf', $layer->join[0]->table);
        self::assertSame('ID', $layer->join[0]->from);
        self::assertSame('IDENT', $layer->join[0]->to);
        self::assertSame('ONE-TO-ONE', $layer->join[0]->type);
        self::assertSame('ON', $layer->labelcache);
        self::assertSame('label', $layer->labelitem);
        self::assertSame(10000.0, $layer->labelmaxscaledenom);
        self::assertSame(0.0, $layer->labelminscaledenom);
        self::assertSame('![orthoquads]', $layer->labelrequires);
        self::assertSame('parcels', $layer->mask);
        self::assertSame(10, $layer->maxfeatures);
        self::assertSame(500.0, $layer->maxgeowidth);
        self::assertSame(10000.0, $layer->maxscaledenom);
        self::assertSame(['title' => 'My layer title'], $layer->metadata);
        self::assertSame(50, $layer->minfeaturesize);
        self::assertSame(50.0, $layer->mingeowidth);
        self::assertSame(1000.0, $layer->minscaledenom);
        self::assertSame('my-layer', $layer->name);
        self::assertSame([0, 0, 0], $layer->offsite);
        self::assertSame('C:/ms4w/msplugins/mssql/msplugin_mssql2008.dll', $layer->plugin);
        self::assertSame(false, $layer->postlabelcache);
        self::assertSame(['CLOSE_CONNECTION=DEFER', 'CONTOUR_INTERVAL=5'], $layer->processing);
        self::assertSame('epsg:4326', $layer->projection);
        self::assertSame('![modis]', $layer->requires);
        self::assertInstanceOf(ScaleToken::class, $layer->scaletoken);
        self::assertSame('%pri%', $layer->scaletoken->name);
        self::assertSame(['0' => '1', '1000' => '2', '10000' => '3'], $layer->scaletoken->values);
        self::assertSame('METERS', $layer->sizeunits);
        self::assertSame('ON', $layer->status);
        self::assertSame('style', $layer->styleitem);
        self::assertSame(24000.0, $layer->symbolscaledenom);
        self::assertSame('template.html', $layer->template);
        self::assertSame('imagery.shp', $layer->tileindex);
        self::assertSame('LOCATION', $layer->tileitem);
        self::assertSame('src_srs', $layer->tilesrs);
        self::assertSame(10.0, $layer->tolerance);
        self::assertSame('PIXELS', $layer->toleranceunits);
        self::assertSame(true, $layer->transform);
        self::assertSame('LINE', $layer->type);
        self::assertSame('DD', $layer->units);
        self::assertSame('{\"id\":\"[fid]\", \"name\":\"[name]\", \"area\":\"[area]\"}', $layer->utfdata);
        self::assertSame('fid', $layer->utfitem);
        self::assertSame(['firstname' => '^[a-zA-Z\-]+$'], $layer->validation);
    }
}
