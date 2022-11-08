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
    /**
     * @return array<array<float>>
     */
    public function parse(string $filename, int $lineNumber = 0): array
    {
        parent::parse($filename, $lineNumber);

        /** @var array<array<float>> */
        $pattern = [];

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^PATTERN$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'PATTERN';
            } elseif ($this->parsing === 'PATTERN' && preg_match('/^([0-9]+(?:\.(?:[0-9]+))?) ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $pattern[] = [
                    floatval($matches[1]),
                    floatval($matches[2]),
                ];
            } elseif ($this->parsing === 'PATTERN' && preg_match('/^END( # PATTERN)?$/i', $line) === 1) {
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
