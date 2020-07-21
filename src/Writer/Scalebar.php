<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Scalebar extends Writer
{
    public function write($scalebar, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'SCALEBAR'.PHP_EOL;

        $this->text .= self::getTextRaw('ALIGN', $scalebar->align, $indentSize + 1, $indent);
        $this->text .= is_array($scalebar->backgroundcolor) ? self::getTextArray('BACKGROUNDCOLOR', $scalebar->backgroundcolor, $indentSize + 1, $indent) : self::getTextString('BACKGROUNDCOLOR', $scalebar->backgroundcolor, $indentSize + 1, $indent);
        $this->text .= is_array($scalebar->color) ? self::getTextArray('COLOR', $scalebar->color, $indentSize + 1, $indent) : self::getTextString('COLOR', $scalebar->color, $indentSize + 1, $indent);
        $this->text .= is_array($scalebar->imagecolor) ? self::getTextArray('IMAGECOLOR', $scalebar->imagecolor, $indentSize + 1, $indent) : self::getTextString('IMAGECOLOR', $scalebar->imagecolor, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('INTERVALS', $scalebar->intervals, $indentSize + 1, $indent);

        if (!is_null($scalebar->label)) {
            $this->text .= (new Label())->write($scalebar->label, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextArray('OFFSET', $scalebar->offset, $indentSize + 1, $indent);
        $this->text .= is_array($scalebar->outlinecolor) ? self::getTextArray('OUTLINECOLOR', $scalebar->outlinecolor, $indentSize + 1, $indent) : self::getTextString('OUTLINECOLOR', $scalebar->outlinecolor, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('POSITION', $scalebar->position, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('SIZE', $scalebar->size, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STATUS', $scalebar->status, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STYLE', $scalebar->style, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('UNITS', $scalebar->units, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # SCALEBAR'.PHP_EOL;

        return $this->text;
    }
}
