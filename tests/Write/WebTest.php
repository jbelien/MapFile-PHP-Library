<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Web as WebObject;
use MapFile\Writer\Web;
use Tests\WriteTest;

final class WebTest extends WriteTest
{
    public function test(): void
    {
        $web = new WebObject();
        $web->browseformat = 'text/html';
        $web->empty = '/empty';
        $web->error = '/error';
        $web->footer = 'footer.html';
        $web->header = 'header.html';
        $web->imagepath = '/imagepath/';
        $web->imageurl = 'localhost';
        $web->legendformat = 'text/html';
        $web->maxscaledenom = 10000;
        $web->maxtemplate = 'maxscale';
        $web->metadata = ['labelcache_map_edge_buffer' => '10', 'ms_enable_modes' => '!*'];
        $web->minscaledenom = 1000;
        $web->mintemplate = 'minscale';
        $web->queryformat = 'text/html';
        $web->template = 'template.html';
        $web->temppath = '/temp/';
        $web->validation = ['firstname' => '^[a-zA-Z\-]+$'];

        $writer = new Web($this->path);
        $writer->writeBlock($web);
        $result = $writer->save();

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
