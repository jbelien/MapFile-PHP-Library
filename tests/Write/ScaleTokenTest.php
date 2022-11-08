<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\ScaleToken;
use MapFile\Writer\ScaleToken as Writer;
use Tests\WriteTest;

final class ScaleTokenTest extends WriteTest
{
    public function test(): void
    {
        $scaletoken = new ScaleToken();
        $scaletoken->name = '%pri%';
        $scaletoken->values = ['0' => '1', '1000' => '2', '10000' => '3'];

        $result = (new Writer($scaletoken))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
