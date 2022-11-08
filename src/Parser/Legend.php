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
use MapFile\Model\Legend as LegendObject;

class Legend extends Parser
{
    public function parse(string $filename, int $lineNumber = 0): LegendObject
    {
        parent::parse($filename, $lineNumber);

        $legend = new LegendObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^LEGEND$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'LEGEND';
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^IMAGECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $legend->imagecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^IMAGECOLOR ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $legend->imagecolor = $matches[1];
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^KEYSIZE ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $legend->keysize = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^KEYSPACING ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $legend->keyspacing = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^LABEL$/i', $line) === 1) {
                $labelParser = new Label();

                $legend->label = $labelParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $labelParser->lineEnd;
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^OUTLINECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $legend->outlinecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^OUTLINECOLOR ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $legend->outlinecolor = $matches[1];
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^POSITION (UL|UC|UR|LL|LC|LR)$/i', $line, $matches) === 1) {
                $legend->position = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^POSTLABELCACHE (TRUE|FALSE)$/i', $line, $matches) === 1) {
                $legend->postlabelcache = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^STATUS (ON|OFF|EMBED)$/i', $line, $matches) === 1) {
                $legend->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^TEMPLATE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $legend->template = $matches[1];
            } elseif ($this->parsing === 'LEGEND' && preg_match('/^END( # LEGEND)?$/i', $line) === 1) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $legend;
    }
}
