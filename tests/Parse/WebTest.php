<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Web as Parser;
use Tests\ParseTest;

final class WebTest extends ParseTest
{
    public function test(): void
    {
        $web = (new Parser())->parse($this->stub);

        self::assertSame('text/html', $web->browseformat);
        self::assertSame('/empty', $web->empty);
        self::assertSame('/error', $web->error);
        self::assertSame('footer.html', $web->footer);
        self::assertSame('header.html', $web->header);
        self::assertSame('/imagepath/', $web->imagepath);
        self::assertSame('localhost', $web->imageurl);
        self::assertSame('text/html', $web->legendformat);
        self::assertSame(10000.0, $web->maxscaledenom);
        self::assertSame('maxscale', $web->maxtemplate);
        self::assertSame(['labelcache_map_edge_buffer' => '10', 'ms_enable_modes' => '!*'], $web->metadata);
        self::assertSame(1000.0, $web->minscaledenom);
        self::assertSame('minscale', $web->mintemplate);
        self::assertSame('text/html', $web->queryformat);
        self::assertSame('template.html', $web->template);
        self::assertSame('/temp/', $web->temppath);
        self::assertSame(['firstname' => '^[a-zA-Z\-]+$'], $web->validation);
    }
}
