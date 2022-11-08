<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Leader;
use MapFile\Model\Style;
use MapFile\Writer\Leader as Writer;
use Tests\WriteTest;

final class LeaderTest extends WriteTest
{
    public function test(): void
    {
        $leader = new Leader();
        $leader->gridstep = 5;
        $leader->maxdistance = 30;

        $style = new Style();
        $style->color = [255, 0, 0];
        $style->width = 1;
        $leader->style[] = $style;

        $result = (new Writer($leader))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
