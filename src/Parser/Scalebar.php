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
use MapFile\Model\Scalebar as ScalebarObject;

class Scalebar extends Parser
{
    public function parse(?array $content = null): ScalebarObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $scalebar = new ScalebarObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^SCALEBAR$/i', $line) !== false) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'SCALEBAR';
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^ALIGN (LEFT|CENTER|RIGHT)$/i', $line, $matches) !== false) {
                $scalebar->align = strtoupper($matches[1]);
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^BACKGROUNDCOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) !== false) {
                $scalebar->backgroundcolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^BACKGROUNDCOLOR ["\'](#.+)["\']$/i', $line, $matches) !== false) {
                $scalebar->backgroundcolor = $matches[1];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^COLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) !== false) {
                $scalebar->color = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^COLOR ["\'](#.+)["\']$/i', $line, $matches) !== false) {
                $scalebar->color = $matches[1];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^IMAGECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) !== false) {
                $scalebar->imagecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^IMAGECOLOR ["\'](#.+)["\']$/i', $line, $matches) !== false) {
                $scalebar->imagecolor = $matches[1];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^INTERVALS ([0-9]+)$/i', $line, $matches) !== false) {
                $scalebar->intervals = intval($matches[1]);
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^LABEL$/i', $line)) {
                $labelParser = new Label($this->file, $this->currentLineIndex - 1);
                $label = $labelParser->parse();

                $scalebar->label = $label;

                $this->currentLineIndex = $labelParser->lineEnd;
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^OFFSET ([0-9]+) ([0-9]+)$/i', $line, $matches) !== false) {
                $scalebar->offset = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^OUTLINECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) !== false) {
                $scalebar->outlinecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^OUTLINECOLOR ["\'](#.+)["\']$/i', $line, $matches) !== false) {
                $scalebar->outlinecolor = $matches[1];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^POSITION (UL|UC|UR|LL|LC|LR)$/i', $line, $matches) !== false) {
                $scalebar->position = strtoupper($matches[1]);
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^POSTLABELCACHE (TRUE|FALSE)$/i', $line, $matches) !== false) {
                $scalebar->postlabelcache = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^SIZE ([0-9]+) ([0-9]+)$/i', $line, $matches) !== false) {
                $scalebar->size = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^STATUS (ON|OFF|EMBED)$/i', $line, $matches) !== false) {
                $scalebar->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^STYLE ([0-9]+)$/i', $line, $matches) !== false) {
                $scalebar->style = intval($matches[1]);
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^UNITS (FEET|INCHES|KILOMETERS|METERS|MILES|NAUTICALMILES)$/i', $line, $matches) !== false) {
                $scalebar->units = strtoupper($matches[1]);
            } elseif ($this->parsing === 'SCALEBAR' && preg_match('/^END( # SCALEBAR)?$/i', $line) !== false) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $scalebar;
    }
}
