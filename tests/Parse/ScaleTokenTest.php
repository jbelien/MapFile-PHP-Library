<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\ScaleToken;
use PHPUnit\Framework\TestCase;

final class ScaleTokenTest extends TestCase
{
    protected string $stub = 'tests/stubs/SCALETOKEN';

    public function test(): void
    {
        $parser = new ScaleToken($this->stub);
        $scaletoken = $parser->parse();

        $this->assertSame('%pri%', $scaletoken->name);
        $this->assertSame(['0' => '1', '1000' => '2', '10000' => '3'], $scaletoken->values);
    }
}
