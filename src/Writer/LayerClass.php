<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

use MapFile\Model\LayerClass as LayerClassObject;

class LayerClass extends Writer
{
    public function __construct(LayerClassObject $class, int $indentSize = 0, string $indent = self::WRITER_INDENT)
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'CLASS'.PHP_EOL;

        $this->text .= self::getTextRaw('DEBUG', $class->debug, $indentSize + 1, $indent);
        $this->text .= self::getText('EXPRESSION', $class->expression, $indentSize + 1, $indent);
        $this->text .= self::getTextString('GROUP', $class->group, $indentSize + 1, $indent);
        $this->text .= self::getTextString('KEYIMAGE', $class->keyimage, $indentSize + 1, $indent);

        foreach ($class->label as $label) {
            $this->text .= (new Label($label, $indentSize + 1, $indent))->text;
        }

        if (!is_null($class->leader)) {
            $this->text .= (new Leader($class->leader, $indentSize + 1, $indent))->text;
        }

        $this->text .= self::getTextRaw('MAXSCALEDENOM', $class->maxscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINSCALEDENOM', $class->minscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $class->name, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STATUS', $class->status, $indentSize + 1, $indent);

        foreach ($class->style as $style) {
            $this->text .= (new Style($style, $indentSize + 1, $indent))->text;
        }

        $this->text .= self::getTextString('TEMPLATE', $class->template, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TEXT', $class->text, $indentSize + 1, $indent);

        if (!is_null($class->validation)) {
            $this->text .= (new Validation($class->validation, $indentSize + 1, $indent))->text;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # CLASS'.PHP_EOL;
    }
}
