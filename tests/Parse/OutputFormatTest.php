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

        self::assertSame('AGG/PNG8', $outputformat->driver);
        self::assertSame('png', $outputformat->extension);
        self::assertSame(['QUANTIZE_FORCE=on', 'QUANTIZE_COLORS=256', 'GAMMA=0.75'], $outputformat->formatoption);
        self::assertSame('RGB', $outputformat->imagemode);
        self::assertSame('image/png; mode=8bit', $outputformat->mimetype);
        self::assertSame('png8', $outputformat->name);
        self::assertSame('ON', $outputformat->transparent);
    }
}
