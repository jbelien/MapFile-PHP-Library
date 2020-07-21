<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Points extends Writer
{
    public function write($points, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'POINTS'.PHP_EOL;

        foreach ($points as $point) {
            $this->text .= str_repeat($indent, $indentSize + 1);
            $this->text .= $point[0].' '.$point[1];
            $this->text .= PHP_EOL;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # POINTS'.PHP_EOL;

        return $this->text;
    }
}
