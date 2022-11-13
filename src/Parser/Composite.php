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
use MapFile\Model\Composite as CompositeObject;

class Composite extends Parser
{
    public function parse(string $filename, int $lineNumber = 0): CompositeObject
    {
        parent::parse($filename, $lineNumber);

        $composite = new CompositeObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^COMPOSITE$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'COMPOSITE';
            } elseif ($this->parsing === 'COMPOSITE' && preg_match('/^COMPFILTER ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $composite->compfilter[] = $matches[1];
            } elseif ($this->parsing === 'COMPOSITE' && preg_match('/^COMPOP ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $composite->compop = $matches[1];
            } elseif ($this->parsing === 'COMPOSITE' && preg_match('/^OPACITY ([0-9]+)$/i', $line, $matches) === 1) {
                $composite->opacity = intval($matches[1]);
            } elseif ($this->parsing === 'COMPOSITE' && preg_match('/^END( # COMPOSITE)?$/i', $line) === 1) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $composite;
    }
}
