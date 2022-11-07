<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Cluster;
use Tests\ParseTest;

final class ClusterTest extends ParseTest
{
    public function test(): void
    {
        $parser = new Cluster($this->stub);
        $cluster = $parser->parse();

        self::assertSame(0.5, $cluster->buffer);
        self::assertSame(1.5, $cluster->maxdistance);
        self::assertSame('rectangle', $cluster->region);
    }
}
