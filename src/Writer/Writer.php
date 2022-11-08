<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

use MapFile\Model\MapFileObject;

abstract class Writer
{
    const WRITER_INDENT = '  ';

    /** @var string */
    protected $text;

    public function save(string $filename): bool
    {
        $result = file_put_contents($filename, $this->text);

        return false !== $result;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param int    $indentSize
     * @param string $indent
     *
     * @return string
     */
    protected static function getTextRaw(string $key, $value, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $text = '';

        if (!is_null($value)) {
            $text = str_repeat($indent, $indentSize);
            $text .= strtoupper($key);
            $text .= ' ';
            $text .= (string) $value;
            $text .= PHP_EOL;
        }

        return $text;
    }

    /**
     * @param string                       $key
     * @param null|array<string|int|float> $value
     * @param int                          $indentSize
     * @param string                       $indent
     *
     * @return string
     */
    protected static function getTextArray(string $key, ?array $value, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        return is_null($value) ? '' : self::getTextRaw($key, implode(' ', $value), $indentSize, $indent);
    }

    protected static function getTextBoolean(string $key, ?bool $value, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        return is_null($value) ? '' : self::getTextRaw($key, $value ? 'TRUE' : 'FALSE', $indentSize, $indent);
    }

    protected static function getTextString(string $key, ?string $value, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        return is_null($value) ? '' : self::getTextRaw($key, '"'.$value.'"', $indentSize, $indent);
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param int    $indentSize
     * @param string $indent
     *
     * @return string
     */
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
}
