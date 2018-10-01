<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Symbol extends Writer
{
    public function write($symbol, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'SYMBOL'.PHP_EOL;

        $this->text .= self::getTextArray('ANCHORPOINT', $symbol->anchorpoint, $indentSize + 1, $indent);
        $this->text .= self::getTextBoolean('ANTIALIAS', $symbol->antialias, $indentSize + 1, $indent);
        $this->text .= self::getTextString('CHARACTER', $symbol->character, $indentSize + 1, $indent);
        $this->text .= self::getTextBoolean('FILLED', $symbol->filled, $indentSize + 1, $indent);
        $this->text .= self::getTextString('FONT', $symbol->font, $indentSize + 1, $indent);
        $this->text .= self::getTextString('IMAGE', $symbol->image, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $symbol->name, $indentSize + 1, $indent);

        if (!is_null($symbol->points)) {
            $this->text .= (new Points())->write($symbol->points, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextRaw('TRANSPARENT', $symbol->transparent, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TYPE', $symbol->type, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # SYMBOL'.PHP_EOL;

        return $this->text;
    }
}
