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

class ScaleTokenValues extends Writer
{
    public function write($values, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!is_array($values) || $values !== array_filter($values, fn ($value, $key) => is_string($value), ARRAY_FILTER_USE_BOTH)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an associative array (key/value), "%s" given.',
                    gettype($values)
                )
            );
        }

        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'VALUES'.PHP_EOL;

        /** @var array<int|string,string> $values */
        foreach ($values as $key => $value) {
            $this->text .= str_repeat($indent, $indentSize + 1);
            $this->text .= '"'.$key.'" "'.$value.'"';
            $this->text .= PHP_EOL;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # VALUES'.PHP_EOL;

        return $this->text;
    }
}
