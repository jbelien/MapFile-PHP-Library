<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Reference extends Writer
{
    public function write($reference, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'REFERENCE'.PHP_EOL;

        $this->text .= is_array($reference->color) ? self::getTextArray('COLOR', $reference->color, $indentSize + 1, $indent) : self::getTextString('COLOR', $reference->color, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('EXTENT', $reference->extent, $indentSize + 1, $indent);
        $this->text .= self::getTextString('IMAGE', $reference->image, $indentSize + 1, $indent);
        $this->text .= is_int($reference->marker) ? self::getTextRaw('MARKER', $reference->marker, $indentSize + 1, $indent) : self::getTextString('MARKER', $reference->marker, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MARKERSIZE', $reference->markersize, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXBOXSIZE', $reference->maxboxsize, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINBOXSIZE', $reference->minboxsize, $indentSize + 1, $indent);
        $this->text .= is_array($reference->outlinecolor) ? self::getTextArray('OUTLINECOLOR', $reference->outlinecolor, $indentSize + 1, $indent) : self::getTextString('OUTLINECOLOR', $reference->outlinecolor, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('SIZE', $reference->size, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STATUS', $reference->status, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # REFERENCE'.PHP_EOL;

        return $this->text;
    }
}
