<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Pattern extends Writer
{
    public function write($pattern, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'PATTERN'.PHP_EOL;

        foreach ($pattern as $p) {
            $this->text .= str_repeat($indent, $indentSize + 1);
            $this->text .= $p[0].' '.$p[1];
            $this->text .= PHP_EOL;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # PATTERN'.PHP_EOL;

        return $this->text;
    }
}
