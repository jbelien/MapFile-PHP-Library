<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Parser;

use MapFile\Exception\UnsupportedException;
use MapFile\Model\Feature as FeatureObject;

class Feature extends Parser
{
    public function parse(?array $content = null): FeatureObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $feature = new FeatureObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^FEATURE$/i', $line) !== false) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'FEATURE';
            } elseif ($this->parsing === 'FEATURE' && preg_match('/^POINTS$/i', $line) !== false) {
                $pointsParser = new Points($this->file, $this->currentLineIndex - 1);
                $points = $pointsParser->parse();

                $feature->points[] = $points;

                $this->currentLineIndex = $pointsParser->lineEnd;
            } elseif ($this->parsing === 'FEATURE' && preg_match('/^ITEMS ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $feature->items = $matches[1];
            } elseif ($this->parsing === 'FEATURE' && preg_match('/^TEXT ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $feature->text = $matches[1];
            } elseif ($this->parsing === 'FEATURE' && preg_match('/^WKT ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $feature->wkt[] = $matches[1];
            } elseif ($this->parsing === 'FEATURE' && preg_match('/^END( # FEATURE)?$/i', $line) !== false) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $feature;
    }
}
