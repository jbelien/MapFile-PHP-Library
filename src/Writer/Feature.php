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
use MapFile\Model\Feature as FeatureObject;

class Feature extends Writer
{
    public function writeBlock($feature, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!$feature instanceof FeatureObject) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an instance of "Feature", instance of "%s" given.',
                    gettype($feature) === 'object' ? get_class($feature) : gettype($feature)
                )
            );
        }

        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'FEATURE'.PHP_EOL;

        $this->text .= self::getTextString('ITEMS', $feature->items, $indentSize + 1, $indent);

        if (count($feature->points) > 0) {
            $this->text .= (new Points())->writeBlock($feature->points, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextString('TEXT', $feature->text, $indentSize + 1, $indent);
        $this->text .= self::getTextString('WKT', $feature->wkt, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # FEATURE'.PHP_EOL;

        return $this->text;
    }
}
