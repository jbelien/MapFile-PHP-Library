<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Metadata extends Writer
{
    /**
     * @param array<string,string> $metadata
     * @param int                  $indentSize
     * @param string               $indent
     *
     * @return void
     */
    public function __construct(array $metadata, int $indentSize = 0, string $indent = self::WRITER_INDENT)
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'METADATA'.PHP_EOL;

        foreach ($metadata as $key => $value) {
            $this->text .= str_repeat($indent, $indentSize + 1);
            $this->text .= '"'.$key.'" "'.$value.'"';
            $this->text .= PHP_EOL;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # METADATA'.PHP_EOL;
    }
}
