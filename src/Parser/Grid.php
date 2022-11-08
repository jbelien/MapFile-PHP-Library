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
    public function parse(string $filename, int $lineNumber = 0): GridObject
    {
        parent::parse($filename, $lineNumber);

        $grid = new GridObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^GRID$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'GRID';
            } elseif ($this->parsing === 'GRID' && preg_match('/^LABELFORMAT (DD|DDMM|DDMMSS)$/i', $line, $matches) === 1) {
                $grid->labelformat = strtoupper($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^LABELFORMAT ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $grid->labelformat = $matches[1];
            } elseif ($this->parsing === 'GRID' && preg_match('/^MINARCS ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $grid->minarcs = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MAXARCS ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $grid->maxarcs = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MININTERVAL ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $grid->mininterval = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MAXINTERVAL ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $grid->maxinterval = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MINSUBDIVIDE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $grid->minsubdivide = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^MAXSUBDIVIDE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $grid->maxsubdivide = floatval($matches[1]);
            } elseif ($this->parsing === 'GRID' && preg_match('/^END( # GRID)?$/i', $line) === 1) {
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
