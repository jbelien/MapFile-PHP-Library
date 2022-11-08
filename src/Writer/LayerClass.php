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
use MapFile\Model\LayerClass as LayerClassObject;

class LayerClass extends Writer
{
    public function writeBlock($class, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!$class instanceof LayerClassObject) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an instance of "LayerClass", instance of "%s" given.',
                    gettype($class) === 'object' ? get_class($class) : gettype($class)
                )
            );
        }

        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'CLASS'.PHP_EOL;

        $this->text .= self::getTextRaw('DEBUG', $class->debug, $indentSize + 1, $indent);
        $this->text .= self::getText('EXPRESSION', $class->expression, $indentSize + 1, $indent);
        $this->text .= self::getTextString('GROUP', $class->group, $indentSize + 1, $indent);
        $this->text .= self::getTextString('KEYIMAGE', $class->keyimage, $indentSize + 1, $indent);

        foreach ($class->label as $label) {
            $this->text .= (new Label())->writeBlock($label, $indentSize + 1, $indent);
        }

        if (!is_null($class->leader)) {
            $this->text .= (new Leader())->writeBlock($class->leader, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextRaw('MAXSCALEDENOM', $class->maxscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINSCALEDENOM', $class->minscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $class->name, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STATUS', $class->status, $indentSize + 1, $indent);

        foreach ($class->style as $style) {
            $this->text .= (new Style())->writeBlock($style, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextString('TEMPLATE', $class->template, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TEXT', $class->text, $indentSize + 1, $indent);

        if (!is_null($class->validation)) {
            $this->text .= (new Validation())->writeBlock($class->validation, $indentSize + 1, $indent);
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # CLASS'.PHP_EOL;

        return $this->text;
    }
}
