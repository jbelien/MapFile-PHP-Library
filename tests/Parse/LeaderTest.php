<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Leader;
use Tests\ParseTest;

final class LeaderTest extends ParseTest
{
    public function test(): void
    {
        $parser = new Leader($this->stub);
        $leader = $parser->parse();

        $this->assertSame(5, $leader->gridstep);
        $this->assertSame(30, $leader->maxdistance);
        $this->assertSame([255, 0, 0], $leader->style[0]->color);
        $this->assertSame(1.0, $leader->style[0]->width);
    }
}
