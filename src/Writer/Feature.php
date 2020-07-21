<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Feature extends Writer
{
    public function write($feature, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'FEATURE'.PHP_EOL;

        $this->text .= self::getTextString('ITEMS', $feature->items, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TEXT', $feature->text, $indentSize + 1, $indent);

        foreach ($feature->points as $points) {
            $this->text .= (new Points())->write($points, $indentSize + 1, $indent);
        }

        foreach ($feature->wkt as $wkt) {
            $this->text .= self::getTextString('WKT', $wkt, $indentSize + 1, $indent);
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # FEATURE'.PHP_EOL;

        return $this->text;
    }
}
