<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\ScaleToken as Parser;
use Tests\ParseTest;

final class ScaleTokenTest extends ParseTest
{
    public function test(): void
    {
        $scaletoken = (new Parser())->parse($this->stub);

        self::assertSame('%pri%', $scaletoken->name);
        self::assertSame(['0' => '1', '1000' => '2', '10000' => '3'], $scaletoken->values);
    }
}
