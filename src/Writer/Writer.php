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

abstract class Writer implements WriterInterface
{
    const WRITER_INDENT = '  ';

    protected $file;
    protected $text;

    public function __construct(string $file = null)
    {
        $this->file = $file;
    }

    public function save(): bool
    {
        if (!is_null($this->file) && file_exists($this->file) && is_writable($this->file)) {
            $result = file_put_contents($this->file, $this->text);

            return false !== $result;
        }

        return false;
    }

    protected static function getTextRaw(string $key, $value, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $text = '';

        if (!is_null($value)) {
            $text = str_repeat($indent, $indentSize);
            $text .= strtoupper($key);
            $text .= ' ';
            $text .= $value;
            $text .= PHP_EOL;
        }

        return $text;
    }

    protected static function getTextArray(string $key, $value, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!is_null($value) && !is_array($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The value for "%s" must be an array (or NULL).',
                    $key
                )
            );
        }

        return is_null($value) ? '' : self::getTextRaw($key, implode(' ', $value), $indentSize, $indent);
    }

    protected static function getTextBoolean(string $key, $value, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!is_null($value) && !is_bool($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The value for "%s" must be a boolean (or NULL).',
                    $key
                )
            );
        }

        return is_null($value) ? '' : self::getTextRaw($key, $value ? 'TRUE' : 'FALSE', $indentSize, $indent);
    }

    protected static function getTextString(string $key, $value, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!is_null($value) && !is_string($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The value for "%s" must be a string (or NULL).',
                    $key
                )
            );
        }

        return is_null($value) ? '' : self::getTextRaw($key, '"'.$value.'"', $indentSize, $indent);
    }

    protected static function getText(string $key, $value, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (is_null($value)) {
            return '';
        }

        $value = (string) $value;

        if (preg_match('/^\(.+\)$/', $value) === 1) {
            return self::getTextRaw($key, $value, $indentSize, $indent);
        } elseif (preg_match('/^\{.+\}$/', $value) === 1) {
            return self::getTextRaw($key, $value, $indentSize, $indent);
        } elseif (preg_match('/^\[.+\]$/', $value) === 1) {
            return self::getTextRaw($key, $value, $indentSize, $indent);
        } elseif (preg_match('/^\/.+\/[imsxeADSUXJu]*$/', $value) === 1) {
            return self::getTextRaw($key, $value, $indentSize, $indent);
        } else {
            return self::getTextString($key, $value, $indentSize, $indent);
        }
    }

    abstract public function write($object, int $indentSize = 0, string $indent = self::WRITER_INDENT);
}
