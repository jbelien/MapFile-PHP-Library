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

class Projection extends Parser
{
    public function parse($content = null): string
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $projection = '';

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^PROJECTION$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'PROJECTION';
            } elseif ($this->parsing === 'PROJECTION' && preg_match('/^(AUTO)$/i', $line, $matches)) {
                $projection = $matches[1];
            } elseif ($this->parsing === 'PROJECTION' && preg_match('/^"init=(.+)"$/i', $line, $matches)) {
                $projection = $matches[1];
            } elseif ($this->parsing === 'PROJECTION' && preg_match('/^END( # PROJECTION)?$/i', $line)) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $projection;
    }
}
