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
    public function parse($content = null): StyleObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $style = new StyleObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^STYLE$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'STYLE';
            } elseif ($this->parsing === 'STYLE' && preg_match('/^ANGLE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->angle = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^ANGLE (\[.+\])$/i', $line, $matches)) {
                $style->angle = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^ANGLE (AUTO)$/i', $line, $matches)) {
                $style->angle = strtoupper($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^ANTIALIAS (TRUE|FALSE)$/i', $line, $matches)) {
                $style->antialias = (strtoupper($matches[1]) === true);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $style->color = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLOR ["\'](#.+)["\']$/i', $line, $matches)) {
                $style->color = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLOR (\[.+\])$/i', $line, $matches)) {
                $style->color = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLORRANGE ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $style->colorrange = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                    intval($matches[4]),
                    intval($matches[5]),
                    intval($matches[6]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^COLORRANGE ["\'](#.+)["\'] ["\'](#.+)["\']$/i', $line, $matches)) {
                $style->colorrange = [
                    $matches[1],
                    $matches[2],
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^DATARANGE ([0-9]+(?:\.(?:[0-9]+))?) ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->datarange = [
                    floatval($matches[1]),
                    floatval($matches[1]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^GAP ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->gap = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^GEOMTRANSFORM ["\'](bbox|centroid|end|labelpnt|labelpoly|start|vertices)["\']$/i', $line, $matches)) {
                $style->geomtransform = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^GEOMTRANSFORM (\(.+\))$/i', $line, $matches)) {
                $style->geomtransform = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^INITIALGAP ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->initialgap = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^LINECAP (BUTT|ROUND|SQUARE)$/i', $line, $matches)) {
                $style->linecap = strtoupper($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^LINEJOIN (ROUND|MITER|BEVEL|NONE)$/i', $line, $matches)) {
                $style->linejoin = strtoupper($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^LINEJOINMAXSIZE ([0-9]+)$/i', $line, $matches)) {
                $style->linejoinmaxsize = intval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^MAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->maxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^MAXSIZE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->maxsize = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^MINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->minscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^MINSIZE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->minsize = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OFFSET ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $style->offset = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OPACITY ([0-9]+)$/i', $line, $matches)) {
                $style->opacity = intval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OPACITY (\[.+\])$/i', $line, $matches)) {
                $style->opacity = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $style->outlinecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINECOLOR ["\'](#.+)["\']$/i', $line, $matches)) {
                $style->outlinecolor = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINECOLOR (\[.+\])$/i', $line, $matches)) {
                $style->outlinecolor = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINEWIDTH ([0-9]+)$/i', $line, $matches)) {
                $style->outlinewidth = intval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^OUTLINEWIDTH (\[.+\])$/i', $line, $matches)) {
                $style->outlinewidth = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^PATTERN$/i', $line)) {
                $patternParser = new Pattern($this->file, $this->currentLineIndex - 1);
                $pattern = $patternParser->parse();

                $style->pattern = $pattern;

                $this->currentLineIndex = $patternParser->lineEnd;
            } elseif ($this->parsing === 'STYLE' && preg_match('/^POLAROFFSET ([0-9]+(?:\.(?:[0-9]+))?) ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->polaroffset = [
                    floatval($matches[1]),
                    floatval($matches[2]),
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^POLAROFFSET (\[.+\]) (\[.+\])$/i', $line, $matches)) {
                $style->polaroffset = [
                    $matches[1],
                    $matches[2],
                ];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^RANGEITEM (\[.+\])$/i', $line, $matches)) {
                $style->rangeitem = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SIZE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->size = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SIZE (\[.+\])$/i', $line, $matches)) {
                $style->size = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SYMBOL ([0-9]+)$/i', $line, $matches)) {
                $style->symbol = intval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SYMBOL ["\'](.+)["\']$/i', $line, $matches)) {
                $style->symbol = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^SYMBOL (\[.+\])$/i', $line, $matches)) {
                $style->symbol = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^WIDTH ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $style->width = floatval($matches[1]);
            } elseif ($this->parsing === 'STYLE' && preg_match('/^WIDTH (\[.+\])$/i', $line, $matches)) {
                $style->width = $matches[1];
            } elseif ($this->parsing === 'STYLE' && preg_match('/^END( # STYLE)?$/i', $line)) {
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
