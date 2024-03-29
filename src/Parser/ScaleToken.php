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
use MapFile\Model\ScaleToken as ScaleTokenObject;

class ScaleToken extends Parser
{
    public function parse(string $filename, int $lineNumber = 0): ScaleTokenObject
    {
        parent::parse($filename, $lineNumber);

        $scaletoken = new ScaleTokenObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^SCALETOKEN$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'SCALETOKEN';
            } elseif ($this->parsing === 'SCALETOKEN' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $scaletoken->name = $matches[1];
            } elseif ($this->parsing === 'SCALETOKEN' && preg_match('/^VALUES$/i', $line, $matches) === 1) {
                $scaletokenValuesParser = new ScaleTokenValues();

                $scaletoken->values = $scaletokenValuesParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $scaletokenValuesParser->lineEnd;
            } elseif ($this->parsing === 'SCALETOKEN' && preg_match('/^END( # SCALETOKEN)?$/i', $line) === 1) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $scaletoken;
    }
}
