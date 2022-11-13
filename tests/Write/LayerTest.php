<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Cluster;
use MapFile\Model\Composite;
use MapFile\Model\Feature;
use MapFile\Model\Grid;
use MapFile\Model\Join;
use MapFile\Model\Layer;
use MapFile\Model\LayerClass;
use MapFile\Model\ScaleToken;
use MapFile\Writer\Layer as Writer;
use Tests\WriteTest;

final class LayerTest extends WriteTest
{
    public function test(): void
    {
        $layer = new Layer();
        $layer->bindvals = ['1' => 'Nova Scotia'];
        $layer->classgroup = 'group1';
        $layer->classitem = 'column1';
        $layer->connection = 'lakes.db';
        $layer->connectionoptions = ['FLATTEN_NESTED_ATTRIBUTES' => 'YES'];
        $layer->connectiontype = 'OGR';
        $layer->data = 'lakes';
        $layer->debug = 0;
        $layer->encoding = 'UTF-8';
        $layer->extent = [0.0, 0.0, 150000.0, 150000.0];
        $layer->filter = '("[type]"=\'road\' and [size]<2)';
        $layer->filteritem = 'column1';
        $layer->footer = 'footer.html';
        $layer->geomtransform = '(simplify((centerline([shape])), 10000))';
        $layer->group = 'group';
        $layer->header = 'header.html';
        $layer->labelcache = 'ON';
        $layer->labelitem = 'label';
        $layer->labelmaxscaledenom = 10000.0;
        $layer->labelminscaledenom = 0.0;
        $layer->labelrequires = '![orthoquads]';
        $layer->mask = 'parcels';
        $layer->maxfeatures = 10;
        $layer->maxgeowidth = 500.0;
        $layer->maxscaledenom = 10000.0;
        $layer->metadata = ['title' => 'My layer title'];
        $layer->minfeaturesize = 50;
        $layer->mingeowidth = 50.0;
        $layer->minscaledenom = 1000.0;
        $layer->name = 'my-layer';
        $layer->offsite = [0, 0, 0];
        $layer->plugin = 'C:/ms4w/msplugins/mssql/msplugin_mssql2008.dll';
        $layer->postlabelcache = false;
        $layer->processing = ['CLOSE_CONNECTION=DEFER', 'CONTOUR_INTERVAL=5'];
        $layer->projection = 'epsg:4326';
        $layer->requires = '![modis]';
        $layer->sizeunits = 'METERS';
        $layer->status = 'ON';
        $layer->styleitem = 'style';
        $layer->symbolscaledenom = 24000.0;
        $layer->template = 'template.html';
        $layer->tileindex = 'imagery.shp';
        $layer->tileitem = 'LOCATION';
        $layer->tilesrs = 'src_srs';
        $layer->tolerance = 10.0;
        $layer->toleranceunits = 'PIXELS';
        $layer->transform = true;
        $layer->type = 'LINE';
        $layer->units = 'DD';
        $layer->utfdata = '{\"id\":\"[fid]\", \"name\":\"[name]\", \"area\":\"[area]\"}';
        $layer->utfitem = 'fid';
        $layer->validation = ['firstname' => '^[a-zA-Z\-]+$'];

        $class = new LayerClass();
        $class->name = 'name1';
        $class->group = 'group1';
        $layer->class->add($class);

        $layer->cluster = new Cluster();
        $layer->cluster->maxdistance = 20;
        $layer->cluster->region = 'ellipse';

        $composite = new Composite();
        $composite->opacity = 70;
        $layer->composite->add($composite);

        $feature = new Feature();
        $feature->wkt = 'POINT(2000 2500)';
        $layer->feature->add($feature);

        $layer->grid = new Grid();
        $layer->grid->labelformat = 'DD';

        $join = new Join();
        $join->name = 'test';
        $join->table = '../data/lookup.dbf';
        $join->from = 'ID';
        $join->to = 'IDENT';
        $join->type = 'ONE-TO-ONE';
        $layer->join->add($join);

        $layer->scaletoken = new ScaleToken();
        $layer->scaletoken->name = '%pri%';
        $layer->scaletoken->values = ['0' => '1', '1000' => '2', '10000' => '3'];

        $result = (new Writer($layer))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
