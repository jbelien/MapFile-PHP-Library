<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

use InvalidArgumentException;
use MapFile\Model\Symbol as SymbolObject;

class Symbol extends Writer
{
    public function writeBlock($symbol, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!$symbol instanceof SymbolObject) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an instance of "Symbol", instance of "%s" given.',
                    gettype($symbol) === 'object' ? get_class($symbol) : gettype($symbol)
                )
            );
        }

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
            $this->text .= (new Points())->writeBlock($symbol->points, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextRaw('TRANSPARENT', $symbol->transparent, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TYPE', $symbol->type, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # SYMBOL'.PHP_EOL;

        return $this->text;
    }
}
