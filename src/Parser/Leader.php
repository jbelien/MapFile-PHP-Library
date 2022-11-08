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
use MapFile\Model\Leader as LeaderObject;

class Leader extends Parser
{
    public function parse(string $filename, int $lineNumber = 0): LeaderObject
    {
        parent::parse($filename, $lineNumber);

        $leader = new LeaderObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^LEADER$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'LEADER';
            } elseif ($this->parsing === 'LEADER' && preg_match('/^GRIDSTEP ([0-9]+)$/i', $line, $matches) === 1) {
                $leader->gridstep = intval($matches[1]);
            } elseif ($this->parsing === 'LEADER' && preg_match('/^MAXDISTANCE ([0-9]+)$/i', $line, $matches) === 1) {
                $leader->maxdistance = intval($matches[1]);
            } elseif ($this->parsing === 'LEADER' && preg_match('/^STYLE$/i', $line) === 1) {
                $styleParser = new Style();

                $leader->style->add($styleParser->parse($this->file, $this->currentLineIndex - 1));

                $this->currentLineIndex = $styleParser->lineEnd;
            } elseif ($this->parsing === 'LEADER' && preg_match('/^END( # LEADER)?$/i', $line) === 1) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $leader;
    }
}
