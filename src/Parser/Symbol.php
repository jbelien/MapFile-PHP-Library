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
use MapFile\Model\Symbol as SymbolObject;

class Symbol extends Parser
{
    public function parse($content = null): SymbolObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $symbol = new SymbolObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^SYMBOL$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'SYMBOL';
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^ANCHORPOINT ([0-9]+(?:\.(?:[0-9]+))?) ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $symbol->anchorpoint = [
                    floatval($matches[1]),
                    floatval($matches[1]),
                ];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^ANTIALIAS (TRUE|FALSE)$/i', $line, $matches)) {
                $symbol->antialias = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^CHARACTER ["\'](.+)["\']$/i', $line, $matches)) {
                $symbol->character = $matches[1];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^FILLED (TRUE|FALSE)$/i', $line, $matches)) {
                $symbol->filled = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^FONT ["\'](.+)["\']$/i', $line, $matches)) {
                $symbol->font = $matches[1];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^IMAGE ["\'](.+)["\']$/i', $line, $matches)) {
                $symbol->image = $matches[1];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches)) {
                $symbol->name = $matches[1];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^POINTS$/i', $line)) {
                $pointsParser = new Points($this->file, $this->currentLineIndex - 1);
                $points = $pointsParser->parse();

                $symbol->points = $points;

                $this->currentLineIndex = $pointsParser->lineEnd;
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^TRANSPARENT ([0-9]+)$/i', $line, $matches)) {
                $symbol->transparent = intval($matches[1]);
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^TYPE (ELLIPSE|HATCH|PIXMAP|SVG|TRUETYPE|VECTOR)$/i', $line, $matches)) {
                $symbol->type = strtoupper($matches[1]);
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^END( # SYMBOL)?$/i', $line)) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $symbol;
    }
}
