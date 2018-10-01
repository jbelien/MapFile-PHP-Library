<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Label extends Writer
{
    public function write($label, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'LABEL'.PHP_EOL;

        $this->text .= self::getTextRaw('ALIGN', $label->align, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('ANGLE', $label->angle, $indentSize + 1, $indent);
        $this->text .= self::getTextBoolean('ANTIALIAS', $label->antialias, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('BUFFER', $label->buffer, $indentSize + 1, $indent);
        $this->text .= is_array($label->color) ? self::getTextArray('COLOR', $label->color, $indentSize + 1, $indent) : self::getText('COLOR', $label->color, $indentSize + 1, $indent);
        $this->text .= self::getText('EXPRESSION', $label->expression, $indentSize + 1, $indent);
        $this->text .= self::getText('FONT', $label->font, $indentSize + 1, $indent);
        $this->text .= self::getTextBoolean('FORCE', $label->force, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXLENGTH', $label->maxlength, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXOVERLAPANGLE', $label->maxoverlapangle, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXSCALEDENOM', $label->maxscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXSIZE', $label->maxsize, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINDISTANCE', $label->mindistance, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINFEATURESIZE', $label->minfeaturesize, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINSCALEDENOM', $label->minscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINSIZE', $label->minsize, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('OFFSET', $label->offset, $indentSize + 1, $indent);
        $this->text .= is_array($label->outlinecolor) ? self::getTextArray('OUTLINECOLOR', $label->outlinecolor, $indentSize + 1, $indent) : self::getText('OUTLINECOLOR', $label->outlinecolor, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('OUTLINEWIDTH', $label->outlinewidth, $indentSize + 1, $indent);
        $this->text .= self::getTextBoolean('PARTIALS', $label->partials, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('POSITION', $label->position, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('PRIORITY', $label->priority, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('REPEATDISTANCE', $label->repeatdistance, $indentSize + 1, $indent);
        $this->text .= is_array($label->shadowcolor) ? self::getTextArray('SHADOWCOLOR', $label->shadowcolor, $indentSize + 1, $indent) : self::getText('SHADOWCOLOR', $label->shadowcolor, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('SHADOWSIZE', $label->shadowsize, $indentSize + 1, $indent);
        $this->text .= is_array($label->size) ? self::getTextArray('SIZE', $label->size, $indentSize + 1, $indent) : self::getTextRaw('SIZE', $label->size, $indentSize + 1, $indent);

        if (!is_null($label->style)) {
            $this->text .= (new Style())->write($label->style, $indentSize + 1, $indent);
        }

        $this->text .= !is_null($label->text) && preg_match('/^\(.+\)$/', $label->text) === 1 ? self::getTextRaw('TEXT', $label->text, $indentSize + 1, $indent) : self::getTextString('TEXT', $label->text, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TYPE', $label->type, $indentSize + 1, $indent);
        $this->text .= self::getTextString('WRAP', $label->wrap, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # LABEL'.PHP_EOL;

        return $this->text;
    }
}
