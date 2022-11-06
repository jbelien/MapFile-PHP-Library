<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Cluster;
use PHPUnit\Framework\TestCase;

final class ClusterTest extends TestCase
{
    protected string $stub = 'tests/stubs/CLUSTER';

    public function test(): void
    {
        $parser = new Cluster($this->stub);
        $cluster = $parser->parse();

        $this->assertSame(0.5, $cluster->buffer);
        $this->assertSame(1.5, $cluster->maxdistance);
        $this->assertSame('rectangle', $cluster->region);
    }
}
