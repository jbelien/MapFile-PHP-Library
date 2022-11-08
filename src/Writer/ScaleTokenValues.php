<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class ScaleTokenValues extends Writer
{
    /**
     * @param array<int|string,string> $values
     * @param int                      $indentSize
     * @param string                   $indent
     *
     * @return void
     */
    public function __construct(array $values, int $indentSize = 0, string $indent = self::WRITER_INDENT)
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'VALUES'.PHP_EOL;

        foreach ($values as $key => $value) {
            $this->text .= str_repeat($indent, $indentSize + 1);
            $this->text .= '"'.$key.'" "'.$value.'"';
            $this->text .= PHP_EOL;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # VALUES'.PHP_EOL;
    }
}
