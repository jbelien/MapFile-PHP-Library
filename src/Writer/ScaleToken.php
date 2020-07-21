<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class ScaleToken extends Writer
{
    public function write($scaletoken, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'SCALETOKEN'.PHP_EOL;

        $this->text .= self::getTextString('NAME', $scaletoken->name, $indentSize + 1, $indent);

        if (!is_null($scaletoken->values)) {
            $this->text .= (new ScaleTokenValues())->write($scaletoken->values, $indentSize + 1, $indent);
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # SCALETOKEN'.PHP_EOL;

        return $this->text;
    }
}
