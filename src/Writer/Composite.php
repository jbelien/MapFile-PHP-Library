<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

use MapFile\Model\Composite as CompositeObject;

class Composite extends Writer
{
    public function __construct(CompositeObject $composite, int $indentSize = 0, string $indent = self::WRITER_INDENT)
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'COMPOSITE'.PHP_EOL;

        foreach ($composite->compfilter as $compfilter) {
            $this->text .= self::getTextString('COMPFILTER', $compfilter, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextString('COMPOP', $composite->compop, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('OPACITY', $composite->opacity, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # COMPOSITE'.PHP_EOL;
    }
}
