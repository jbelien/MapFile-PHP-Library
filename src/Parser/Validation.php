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

class Validation extends Parser
{
    public function parse(?array $content = null): array
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $values = [];

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^VALIDATION$/i', $line) !== false) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'VALIDATION';
            } elseif ($this->parsing === 'VALIDATION' && preg_match('/^["\'](.+)["\']\s+["\'](.+)["\']$/i', $line, $matches) !== false) {
                $values[$matches[1]] = $matches[2];
            } elseif ($this->parsing === 'VALIDATION' && preg_match('/^\'(.+)\'\s+\'(.+)\'$/i', $line, $matches) !== false) {
                $values[$matches[1]] = $matches[2];
            } elseif ($this->parsing === 'VALIDATION' && preg_match('/^END( # VALIDATION)?$/i', $line) !== false) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $values;
    }
}
