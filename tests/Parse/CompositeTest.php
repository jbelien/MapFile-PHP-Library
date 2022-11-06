<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Composite;
use PHPUnit\Framework\TestCase;

final class CompositeTest extends TestCase
{
    protected string $stub = 'tests/stubs/COMPOSITE';

    public function test(): void
    {
        $parser = new Composite($this->stub);
        $composite = $parser->parse();

        $this->assertSame(100, $composite->opacity);
        $this->assertSame('darken', $composite->compop);
    }
}
