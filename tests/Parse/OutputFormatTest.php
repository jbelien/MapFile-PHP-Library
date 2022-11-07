<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\OutputFormat;
use Tests\ParseTest;

final class OutputFormatTest extends ParseTest
{
    public function test(): void
    {
        $parser = new OutputFormat($this->stub);
        $outputformat = $parser->parse();

        $this->assertSame('AGG/PNG8', $outputformat->driver);
        $this->assertSame('png', $outputformat->extension);
        $this->assertSame(['QUANTIZE_FORCE=on', 'QUANTIZE_COLORS=256', 'GAMMA=0.75'], $outputformat->formatoption);
        $this->assertSame('RGB', $outputformat->imagemode);
        $this->assertSame('image/png; mode=8bit', $outputformat->mimetype);
        $this->assertSame('png8', $outputformat->name);
        $this->assertSame('ON', $outputformat->transparent);
    }
}
