<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\ScaleToken;
use Tests\ParseTest;

final class ScaleTokenTest extends ParseTest
{
    public function test(): void
    {
        $parser = new ScaleToken($this->stub);
        $scaletoken = $parser->parseBlock();

        self::assertSame('%pri%', $scaletoken->name);
        self::assertSame(['0' => '1', '1000' => '2', '10000' => '3'], $scaletoken->values);
    }
}
