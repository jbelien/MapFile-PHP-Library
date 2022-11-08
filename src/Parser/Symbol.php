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
    public function parseBlock(?array $content = null): SymbolObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $symbol = new SymbolObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^SYMBOL$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'SYMBOL';
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^ANCHORPOINT ([0-9]+(?:\.(?:[0-9]+))?) ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $symbol->anchorpoint = [
                    floatval($matches[1]),
                    floatval($matches[1]),
                ];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^ANTIALIAS (TRUE|FALSE)$/i', $line, $matches) === 1) {
                $symbol->antialias = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^CHARACTER ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $symbol->character = $matches[1];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^FILLED (TRUE|FALSE)$/i', $line, $matches) === 1) {
                $symbol->filled = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^FONT ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $symbol->font = $matches[1];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^IMAGE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $symbol->image = $matches[1];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $symbol->name = $matches[1];
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^POINTS$/i', $line) === 1) {
                $pointsParser = new Points($this->file, $this->currentLineIndex - 1);
                $points = $pointsParser->parseBlock();

                $symbol->points = $points;

                $this->currentLineIndex = $pointsParser->lineEnd;
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^TRANSPARENT ([0-9]+)$/i', $line, $matches) === 1) {
                $symbol->transparent = intval($matches[1]);
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^TYPE (ELLIPSE|HATCH|PIXMAP|SVG|TRUETYPE|VECTOR)$/i', $line, $matches) === 1) {
                $symbol->type = strtoupper($matches[1]);
            } elseif ($this->parsing === 'SYMBOL' && preg_match('/^END( # SYMBOL)?$/i', $line) === 1) {
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
