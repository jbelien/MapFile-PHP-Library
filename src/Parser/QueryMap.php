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
use MapFile\Model\QueryMap as QueryMapObject;

class QueryMap extends Parser
{
    public function parse(?array $content = null): QueryMapObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $querymap = new QueryMapObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^QUERYMAP$/i', $line) !== false) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'QUERYMAP';
            } elseif ($this->parsing === 'QUERYMAP' && preg_match('/^COLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) !== false) {
                $querymap->color = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'QUERYMAP' && preg_match('/^COLOR ["\'](#.+)["\']$/i', $line, $matches) !== false) {
                $querymap->color = $matches[1];
            } elseif ($this->parsing === 'QUERYMAP' && preg_match('/^SIZE ([0-9+]) ([0-9+])$/i', $line, $matches) !== false) {
                $querymap->size = [
                    $matches[1],
                    $matches[2],
                ];
            } elseif ($this->parsing === 'QUERYMAP' && preg_match('/^STATUS (ON|OFF)$/i', $line, $matches) !== false) {
                $querymap->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'QUERYMAP' && preg_match('/^STYLE (NORMAL|HILITE|SELECTED)$/i', $line, $matches) !== false) {
                $querymap->style = strtoupper($matches[1]);
            } elseif ($this->parsing === 'QUERYMAP' && preg_match('/^END( # QUERYMAP)?$/i', $line) !== false) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $querymap;
    }
}
