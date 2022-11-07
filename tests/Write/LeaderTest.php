<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Leader as LeaderObject;
use MapFile\Model\Style;
use MapFile\Writer\Leader;
use Tests\WriteTest;

final class LeaderTest extends WriteTest
{
    public function test(): void
    {
        $leader = new LeaderObject();
        $leader->gridstep = 5;
        $leader->maxdistance = 30;

        $style = new Style();
        $style->color = [255, 0, 0];
        $style->width = 1;
        $leader->style[] = $style;

        $writer = new Leader($this->path);
        $writer->write($leader);
        $result = $writer->save();

        $this->assertTrue($result);
        $this->assertFileEquals($this->stub, $this->path);
    }
}
