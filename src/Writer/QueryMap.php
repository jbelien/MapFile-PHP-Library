<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class QueryMap extends Writer
{
    public function write($querymap, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'QUERYMAP'.PHP_EOL;

        $this->text .= is_array($querymap->color) ? self::getTextArray('COLOR', $querymap->color, $indentSize + 1, $indent) : self::getTextString('COLOR', $querymap->color, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('SIZE', $querymap->size, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STATUS', $querymap->status, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STYLE', $querymap->style, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # QUERYMAP'.PHP_EOL;

        return $this->text;
    }
}
