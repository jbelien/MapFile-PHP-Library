<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Projection extends Writer
{
    public function write($projection, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'PROJECTION'.PHP_EOL;

        $this->text .= str_repeat($indent, $indentSize + 1);
        $this->text .= '"init='.$projection.'"';
        $this->text .= PHP_EOL;

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # PROJECTION'.PHP_EOL;

        return $this->text;
    }
}
