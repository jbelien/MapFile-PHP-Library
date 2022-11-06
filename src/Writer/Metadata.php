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

class Metadata extends Writer
{
    public function write($metadata, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!is_array($metadata)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an array, "%s" given.',
                    gettype($metadata)
                )
            );
        }

        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'METADATA'.PHP_EOL;

        foreach ($metadata as $key => $value) {
            $this->text .= str_repeat($indent, $indentSize + 1);
            $this->text .= '"'.$key.'" "'.$value.'"';
            $this->text .= PHP_EOL;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # METADATA'.PHP_EOL;

        return $this->text;
    }
}
