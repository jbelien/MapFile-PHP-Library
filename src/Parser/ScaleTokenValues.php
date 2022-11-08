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

class ScaleTokenValues extends Parser
{
    /**
     * @return array<string,string>
     */
    public function parseBlock(?array $content = null): array
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        /** @var array<string,string> */
        $values = [];

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^VALUES$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'VALUES';
            } elseif ($this->parsing === 'VALUES' && preg_match('/^["\'](.+)["\']\s["\'](.+)["\']$/i', $line, $matches) === 1) {
                $values[$matches[1]] = $matches[2];
            } elseif ($this->parsing === 'VALUES' && preg_match('/^END( # VALUES)?$/i', $line) === 1) {
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
