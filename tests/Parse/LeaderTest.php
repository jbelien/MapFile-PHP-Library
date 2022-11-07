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

        self::assertSame(5, $leader->gridstep);
        self::assertSame(30, $leader->maxdistance);
        self::assertSame([255, 0, 0], $leader->style[0]->color);
        self::assertSame(1.0, $leader->style[0]->width);
    }
}
