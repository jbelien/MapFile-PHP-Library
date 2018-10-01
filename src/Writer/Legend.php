<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Legend extends Writer
{
    public function write($legend, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'LEGEND'.PHP_EOL;

        $this->text .= is_array($legend->imagecolor) ? self::getTextArray('IMAGECOLOR', $legend->imagecolor, $indentSize + 1, $indent) : self::getTextString('IMAGECOLOR', $legend->imagecolor, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('KEYSIZE', $legend->keysize, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('KEYSPACING', $legend->keyspacing, $indentSize + 1, $indent);

        if (!is_null($legend->label)) {
            $this->text .= (new Label())->write($legend->label, $indentSize + 1, $indent);
        }

        $this->text .= is_array($legend->outlinecolor) ? self::getTextArray('OUTLINECOLOR', $legend->outlinecolor, $indentSize + 1, $indent) : self::getTextString('OUTLINECOLOR', $legend->outlinecolor, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('POSITION', $legend->position, $indentSize + 1, $indent);
        $this->text .= self::getTextBoolean('POSTLABELCACHE', $legend->postlabelcache, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STATUS', $legend->status, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TEMPLATE', $legend->template, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # LEGEND'.PHP_EOL;

        return $this->text;
    }
}
