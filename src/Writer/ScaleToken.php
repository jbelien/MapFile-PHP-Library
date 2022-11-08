<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

use MapFile\Model\ScaleToken as ScaleTokenObject;

class ScaleToken extends Writer
{
    public function __construct(ScaleTokenObject $scaletoken, int $indentSize = 0, string $indent = self::WRITER_INDENT)
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'SCALETOKEN'.PHP_EOL;

        $this->text .= self::getTextString('NAME', $scaletoken->name, $indentSize + 1, $indent);

        if (count($scaletoken->values) > 0) {
            $this->text .= (new ScaleTokenValues($scaletoken->values, $indentSize + 1, $indent))->text;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # SCALETOKEN'.PHP_EOL;
    }
}
