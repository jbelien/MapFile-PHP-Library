<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Label;
use MapFile\Model\ScaleToken as ScaleTokenObject;
use MapFile\Writer\ScaleToken;
use Tests\WriteTest;

final class ScaleTokenTest extends WriteTest
{
    public function test(): void
    {
        $scaletoken = new ScaleTokenObject();
        $scaletoken->name = '%pri%';
        $scaletoken->values = ['0' => '1', '1000' => '2', '10000' => '3'];

        $writer = new ScaleToken($this->path);
        $writer->write($scaletoken);
        $result = $writer->save();

        $this->assertTrue($result);
        $this->assertFileEquals($this->stub, $this->path);
    }
}
