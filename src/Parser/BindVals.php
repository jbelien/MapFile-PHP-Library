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

class BindVals extends Parser
{
    /**
     * @return string[]
     */
    public function parse(string $filename, int $lineNumber = 0): array
    {
        parent::parse($filename, $lineNumber);

        /** @var string[] */
        $values = [];

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^BINDVALS$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'BINDVALS';
            } elseif ($this->parsing === 'BINDVALS' && preg_match('/^["\'](.+)["\']\s["\'](.*)["\']$/i', $line, $matches) === 1) {
                $values[$matches[1]] = $matches[2];
            } elseif ($this->parsing === 'BINDVALS' && preg_match('/^END( # BINDVALS)?$/i', $line) === 1) {
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
