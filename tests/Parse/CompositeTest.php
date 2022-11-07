<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Composite;
use Tests\ParseTest;

final class CompositeTest extends ParseTest
{
    public function test(): void
    {
        $parser = new Composite($this->stub);
        $composite = $parser->parse();

        self::assertSame(100, $composite->opacity);
        self::assertSame('darken', $composite->compop);
    }
}
