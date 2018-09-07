<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Style extends Writer
{
    public function write($style, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'STYLE'.PHP_EOL;

        $this->text .= self::getText('ANGLE', $style->angle, $indentSize + 1, $indent);
        $this->text .= self::getTextBoolean('ANTIALIAS', $style->antialias, $indentSize + 1, $indent);
        $this->text .= is_array($style->color) ? self::getTextArray('COLOR', $style->color, $indentSize + 1, $indent) : self::getTextString('COLOR', $style->color, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('COLORRANGE', $style->colorrange, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('DATARANGE', $style->datarange, $indentSize + 1, $indent);
        $this->text .= self::getText('GAP', $style->gap, $indentSize + 1, $indent);
        $this->text .= self::getText('INITIALGAP', $style->initialgap, $indentSize + 1, $indent);
        $this->text .= self::getText('LINECAP', $style->linecap, $indentSize + 1, $indent);
        $this->text .= self::getText('LINEJOIN', $style->linejoin, $indentSize + 1, $indent);
        $this->text .= self::getText('LINEJOINMAXSIZE', $style->linejoinmaxsize, $indentSize + 1, $indent);
        $this->text .= self::getText('MAXSCALEDENOM', $style->maxscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getText('MAXSIZE', $style->maxsize, $indentSize + 1, $indent);
        $this->text .= self::getText('MINSCALEDENOM', $style->minscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getText('MINSIZE', $style->minsize, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('OFFSET', $style->offset, $indentSize + 1, $indent);
        $this->text .= is_array($style->outlinecolor) ? self::getTextArray('OUTLINECOLOR', $style->outlinecolor, $indentSize + 1, $indent) : self::getTextString('OUTLINECOLOR', $style->outlinecolor, $indentSize + 1, $indent);
        $this->text .= self::getText('OUTLINEWIDTH', $style->outlinewidth, $indentSize + 1, $indent);

        if (!empty($style->pattern)) {
            $this->text .= (new Pattern())->write($style->pattern, $indentSize + 1, $indent);
        }

        $this->text .= self::getText('RANGEITEM', $style->rangeitem, $indentSize + 1, $indent);
        $this->text .= self::getText('SIZE', $style->size, $indentSize + 1, $indent);
        $this->text .= self::getTextString('SYMBOL', $style->symbol, $indentSize + 1, $indent);
        $this->text .= self::getText('WIDTH', $style->width, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # STYLE'.PHP_EOL;

        return $this->text;
    }
}
