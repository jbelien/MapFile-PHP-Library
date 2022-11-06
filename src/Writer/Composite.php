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
use MapFile\Model\Composite as CompositeObject;

class Composite extends Writer
{
    public function write($composite, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!$composite instanceof CompositeObject) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an instance of "Composite", instance of "%s" given.',
                    gettype($composite) === 'object' ? get_class($composite) : gettype($composite)
                )
            );
        }

        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'COMPOSITE'.PHP_EOL;

        $this->text .= self::getTextRaw('OPACITY', $composite->opacity, $indentSize + 1, $indent);
        $this->text .= self::getTextString('COMPOP', $composite->compop, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # COMPOSITE'.PHP_EOL;

        return $this->text;
    }
}
