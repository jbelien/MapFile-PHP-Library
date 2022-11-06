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
use MapFile\Model\OutputFormat as OutputFormatObject;

class OutputFormat extends Writer
{
    public function write($outputformat, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!$outputformat instanceof OutputFormatObject) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an instance of "OutputFormat", instance of "%s" given.',
                    gettype($outputformat) === 'object' ? get_class($outputformat) : gettype($outputformat)
                )
            );
        }

        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'OUTPUTFORMAT'.PHP_EOL;

        $this->text .= self::getTextRaw('DRIVER', $outputformat->driver, $indentSize + 1, $indent);
        $this->text .= self::getTextString('EXTENSION', $outputformat->extension, $indentSize + 1, $indent);

        foreach ($outputformat->formatoption as $formatoption) {
            $this->text .= self::getTextString('FORMATOPTION', $formatoption, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextRaw('IMAGEMODE', $outputformat->imagemode, $indentSize + 1, $indent);
        $this->text .= self::getTextString('MIMETYPE', $outputformat->mimetype, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $outputformat->name, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TRANSPARENT', $outputformat->transparent, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # OUTPUTFORMAT'.PHP_EOL;

        return $this->text;
    }
}
