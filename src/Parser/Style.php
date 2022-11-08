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
use MapFile\Model\Style as StyleObject;

class Style extends Parser
{
    public function parseBlock(?array $content = null): StyleObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $style = new StyleObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^STYLE$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'STYLE';
            } elseif ($this->parsing === 'STYLE' && preg_match('/^ANGLE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->angle = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^ANGLE (\[.+\])$/i', $line, $matches) === 1) {
                $style->angle = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^ANGLE (AUTO)$/i', $line, $matches) === 1) {
                $style->angle = strtoupper($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^ANTIALIAS (TRUE|FALSE)$/i', $line, $matches) === 1) {
                $style->antialias = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $style->color = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLOR ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $style->color = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLOR (\[.+\])$/i', $line, $matches) === 1) {
                $style->color = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLORRANGE ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $style->colorrange = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                    intval($matches[4]),
                    intval($matches[5]),
                    intval($matches[6]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLORRANGE ["\'](#.+)["\'] ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $style->colorrange = [
                    $matches[1],
                    $matches[2],
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^DATARANGE ([0-9]+(?:\.(?:[0-9]+))?) ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->datarange = [
                    floatval($matches[1]),
                    floatval($matches[1]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^GAP ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->gap = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^GEOMTRANSFORM ["\'](bbox|centroid|end|labelcenter|labelpnt|labelpoly|start|vertices)["\']$/i', $line, $matches) === 1) {
                $style->geomtransform = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^GEOMTRANSFORM (\(.+\))$/i', $line, $matches) === 1) {
                $style->geomtransform = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^INITIALGAP ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->initialgap = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^LINECAP (BUTT|ROUND|SQUARE)$/i', $line, $matches) === 1) {
                $style->linecap = strtoupper($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^LINEJOIN (ROUND|MITER|BEVEL|NONE)$/i', $line, $matches) === 1) {
                $style->linejoin = strtoupper($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^LINEJOINMAXSIZE ([0-9]+)$/i', $line, $matches) === 1) {
                $style->linejoinmaxsize = intval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^MAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->maxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^MAXSIZE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->maxsize = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^MINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->minscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^MINSIZE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->minsize = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OFFSET ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $style->offset = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OPACITY ([0-9]+)$/i', $line, $matches) === 1) {
                $style->opacity = intval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OPACITY (\[.+\])$/i', $line, $matches) === 1) {
                $style->opacity = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $style->outlinecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINECOLOR ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $style->outlinecolor = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINECOLOR (\[.+\])$/i', $line, $matches) === 1) {
                $style->outlinecolor = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINEWIDTH ([0-9]+)$/i', $line, $matches) === 1) {
                $style->outlinewidth = intval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINEWIDTH (\[.+\])$/i', $line, $matches) === 1) {
                $style->outlinewidth = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^PATTERN$/i', $line) === 1) {
                $patternParser = new Pattern($this->file, $this->currentLineIndex - 1);
                $pattern = $patternParser->parseBlock();

                $style->pattern = $pattern;

                $this->currentLineIndex = $patternParser->lineEnd;
            } elseif ($this->parsing === 'STYLE' && preg_match('/^POLAROFFSET ([0-9]+(?:\.(?:[0-9]+))?) ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->polaroffset = [
                    floatval($matches[1]),
                    floatval($matches[2]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^POLAROFFSET (\[.+\]) (\[.+\])$/i', $line, $matches) === 1) {
                $style->polaroffset = [
                    $matches[1],
                    $matches[2],
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^RANGEITEM (\[.+\])$/i', $line, $matches) === 1) {
                $style->rangeitem = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SIZE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->size = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SIZE (\[.+\])$/i', $line, $matches) === 1) {
                $style->size = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SYMBOL ([0-9]+)$/i', $line, $matches) === 1) {
                $style->symbol = intval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SYMBOL ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $style->symbol = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SYMBOL (\[.+\])$/i', $line, $matches) === 1) {
                $style->symbol = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^WIDTH ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $style->width = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^WIDTH (\[.+\])$/i', $line, $matches) === 1) {
                $style->width = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^END( # STYLE)?$/i', $line) === 1) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $style;
    }
}
