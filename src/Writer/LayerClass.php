<?php

declare (strict_types = 1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class LayerClass extends Writer
{
    public function write($class, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'CLASS' . PHP_EOL;

        $this->text .= self::getText('DEBUG', $class->debug, $indentSize + 1, $indent);
        $this->text .= !is_null($class->expression) && preg_match('/^\(.+\)$/', $class->expression) === 1 ? self::getText('EXPRESSION', $class->expression, $indentSize + 1, $indent) : self::getTextString('EXPRESSION', $class->expression, $indentSize + 1, $indent);
        $this->text .= self::getTextString('GROUP', $class->group, $indentSize + 1, $indent);
        $this->text .= self::getTextString('KEYIMAGE', $class->keyimage, $indentSize + 1, $indent);

        if (!is_null($class->leader)) {
            $this->text .= (new Leader())->write($class->leader, $indentSize + 1, $indent);
        }

        $this->text .= self::getText('MAXSCALEDENOM', $class->maxscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getText('MINSCALEDENOM', $class->minscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $class->name, $indentSize + 1, $indent);
        $this->text .= self::getText('STATUS', $class->status, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TEMPLATE', $class->template, $indentSize + 1, $indent);
        $this->text .= !is_null($class->text) && preg_match('/^\(.+\)$/', $class->text) === 1 ? self::getText('TEXT', $class->text, $indentSize + 1, $indent) : self::getTextString('TEXT', $class->text, $indentSize + 1, $indent);

        if (!is_null($class->validation)) {
            $this->text .= (new Validation())->write($layer->validation, $indentSize + 1, $indent);
        }

        foreach ($class->label as $label) {
            $this->text .= (new Label())->write($label, $indentSize + 1, $indent);
        }

        foreach ($class->style as $style) {
            $this->text .= (new Style())->write($style, $indentSize + 1, $indent);
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # CLASS' . PHP_EOL;

        return $this->text;
    }
}
