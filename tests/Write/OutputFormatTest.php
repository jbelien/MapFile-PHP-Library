<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\OutputFormat as OutputFormatObject;
use MapFile\Writer\OutputFormat;
use Tests\WriteTest;

final class OutputFormatTest extends WriteTest
{
    public function test(): void
    {
        $outputformat = new OutputFormatObject();
        $outputformat->driver = 'AGG/PNG8';
        $outputformat->extension = 'png';
        $outputformat->formatoption = [
            'QUANTIZE_FORCE=on',
            'QUANTIZE_COLORS=256',
            'GAMMA=0.75',
        ];
        $outputformat->imagemode = 'RGB';
        $outputformat->mimetype = 'image/png; mode=8bit';
        $outputformat->name = 'png8';
        $outputformat->transparent = 'ON';

        $writer = new OutputFormat($this->path);
        $writer->writeBlock($outputformat);
        $result = $writer->save();

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
