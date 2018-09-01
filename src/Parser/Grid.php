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
use MapFile\Model\Grid as GridObject;

class Grid extends Parser
{
    public function parse($content = null): GridObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $grid = new GridObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^GRID$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'GRID';
            } elseif ($this->parsing === 'GRID' && preg_match('/^LABELFORMAT (DD|DDMM|DDMMSS)$/i', $line, $matches)) {
                $grid->labelformat = strtoupper($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^LABELFORMAT ["\'](.+)["\']$/i', $line, $matches)) {
                $grid->labelformat = $matches[1];
            } elseif ($this->parsing === 'GRID' && preg_match('/^MINARCS ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $grid->minarcs = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MAXARCS ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $grid->maxarcs = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MININTERVAL ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $grid->mininterval = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MAXINTERVAL ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $grid->maxinterval = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MINSUBDIVIDE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $grid->minsubdivide = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MAXSUBDIVIDE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $grid->maxsubdivide = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^END( # GRID)?$/i', $line)) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $grid;
    }
}
