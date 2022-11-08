<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Composite as Parser;
use Tests\ParseTest;

final class CompositeTest extends ParseTest
{
    public function test(): void
    {
        $composite = (new Parser())->parse($this->stub);

        self::assertSame(100, $composite->opacity);
        self::assertSame('darken', $composite->compop);
    }
}
