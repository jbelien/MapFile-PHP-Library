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
    public function parse(?array $content = null): LeaderObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $leader = new LeaderObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^LEADER$/i', $line) !== false) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'LEADER';
            } elseif ($this->parsing === 'LEADER' && preg_match('/^GRIDSTEP ([0-9]+)$/i', $line, $matches) !== false) {
                $leader->gridstep = intval($matches[1]);
            } elseif ($this->parsing === 'LEADER' && preg_match('/^MAXDISTANCE ([0-9]+)$/i', $line, $matches) !== false) {
                $leader->maxdistance = intval($matches[1]);
            } elseif ($this->parsing === 'LEADER' && preg_match('/^STYLE$/i', $line) !== false) {
                $styleParser = new Style($this->file, $this->currentLineIndex - 1);
                $style = $styleParser->parse();

                $leader->style->add($style);

                $this->currentLineIndex = $styleParser->lineEnd;
            } elseif ($this->parsing === 'LEADER' && preg_match('/^END( # LEADER)?$/i', $line) !== false) {
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
