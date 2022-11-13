<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class BindVals extends Writer
{
    /**
     * @param array<int|string,string> $bindvals
     * @param int                      $indentSize
     * @param string                   $indent
     *
     * @return void
     */
    public function __construct(array $bindvals, int $indentSize = 0, string $indent = self::WRITER_INDENT)
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'BINDVALS'.PHP_EOL;

        foreach ($bindvals as $key => $value) {
            $this->text .= str_repeat($indent, $indentSize + 1);
            $this->text .= '"'.$key.'" "'.$value.'"';
            $this->text .= PHP_EOL;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # BINDVALS'.PHP_EOL;
    }
}
