<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Web;
use MapFile\Writer\Web as Writer;
use Tests\WriteTest;

final class WebTest extends WriteTest
{
    public function test(): void
    {
        $web = new Web();
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

        $result = (new Writer($web))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
