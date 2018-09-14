<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class OutputFormat extends Writer
{
    public function write($outputformat, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'OUTPUTFORMAT'.PHP_EOL;

        $this->text .= self::getText('DRIVER', $outputformat->driver, $indentSize + 1, $indent);
        $this->text .= self::getTextString('EXTENSION', $outputformat->extension, $indentSize + 1, $indent);
        $this->text .= self::getText('IMAGEMODE', $outputformat->imagemode, $indentSize + 1, $indent);
        $this->text .= self::getTextString('MIMETYPE', $outputformat->mimetype, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $outputformat->name, $indentSize + 1, $indent);
        $this->text .= self::getText('TRANSPARENT', $outputformat->transparent, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # OUTPUTFORMAT'.PHP_EOL;

        return $this->text;
    }
}