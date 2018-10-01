<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Cluster extends Writer
{
    public function write($cluster, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'CLUSTER'.PHP_EOL;

        $this->text .= self::getTextRaw('BUFFER', $cluster->buffer, $indentSize + 1, $indent);
        $this->text .= self::getTextString('FILTER', $cluster->filter, $indentSize + 1, $indent);
        $this->text .= self::getTextString('GROUP', $cluster->group, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXDISTANCE', $cluster->maxdistance, $indentSize + 1, $indent);
        $this->text .= self::getTextString('REGION', $cluster->region, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # CLUSTER'.PHP_EOL;

        return $this->text;
    }
}
