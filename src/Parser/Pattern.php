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

class Pattern extends Parser
{
    public function parse($content = null): array
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $pattern = [];

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^PATTERN$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'PATTERN';
            } elseif ($this->parsing === 'PATTERN' && preg_match('/^([0-9]+(?:\.(?:[0-9]+))?) ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $pattern[] = [
                    $matches[1],
                    $matches[2],
                ];
            } elseif ($this->parsing === 'PATTERN' && preg_match('/^END( # PATTERN)?$/i', $line)) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $pattern;
    }
}
