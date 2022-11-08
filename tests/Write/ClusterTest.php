<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Cluster;
use MapFile\Writer\Cluster as Writer;
use Tests\WriteTest;

final class ClusterTest extends WriteTest
{
    public function test(): void
    {
        $cluster = new Cluster();
        $cluster->buffer = 0.5;
        $cluster->maxdistance = 1.5;
        $cluster->region = 'rectangle';

        $result = (new Writer($cluster))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
