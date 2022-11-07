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
    public function parse(?array $content = null): ScaleTokenObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

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
                $scaletokenValuesParser = new ScaleTokenValues($this->file, $this->currentLineIndex - 1);
                $scaletokenValues = $scaletokenValuesParser->parse();

                $scaletoken->values = $scaletokenValues;

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
