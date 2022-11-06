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

class Validation extends Writer
{
    public function write($validation, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!is_array($validation)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an array, "%s" given.',
                    gettype($validation)
                )
            );
        }

        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'VALIDATION'.PHP_EOL;

        foreach ($validation as $key => $value) {
            $this->text .= str_repeat($indent, $indentSize + 1);
            $this->text .= '"'.$key.'" "'.$value.'"';
            $this->text .= PHP_EOL;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # VALIDATION'.PHP_EOL;

        return $this->text;
    }
}
