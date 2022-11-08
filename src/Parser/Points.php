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

class Points extends Parser
{
    /**
     * @return array<array<float>>
     */
    public function parseBlock(?array $content = null): array
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        /** @var array<array<float>> */
        $points = [];

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^POINTS$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'POINTS';
            } elseif ($this->parsing === 'POINTS' && preg_match('/^([0-9]+(?:\.(?:[0-9]+))?) ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $points[] = [
                    floatval($matches[1]),
                    floatval($matches[2]),
                ];
            } elseif ($this->parsing === 'POINTS' && preg_match('/^END( # POINTS)?$/i', $line) === 1) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $points;
    }
}
