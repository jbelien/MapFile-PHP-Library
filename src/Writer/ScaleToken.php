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
use MapFile\Model\ScaleToken as ScaleTokenObject;

class ScaleToken extends Writer
{
    public function write($scaletoken, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!$scaletoken instanceof ScaleTokenObject) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an instance of "ScaleToken", instance of "%s" given.',
                    gettype($scaletoken) === 'object' ? get_class($scaletoken) : gettype($scaletoken)
                )
            );
        }

        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'SCALETOKEN'.PHP_EOL;

        $this->text .= self::getTextString('NAME', $scaletoken->name, $indentSize + 1, $indent);

        if (count($scaletoken->values) > 0) {
            $this->text .= (new ScaleTokenValues())->write($scaletoken->values, $indentSize + 1, $indent);
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # SCALETOKEN'.PHP_EOL;

        return $this->text;
    }
}
