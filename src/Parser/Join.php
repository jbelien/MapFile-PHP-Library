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
use MapFile\Model\Join as JoinObject;

class Join extends Parser
{
    public function parse($content = null): JoinObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $join = new JoinObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^JOIN$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'JOIN';
            } elseif ($this->parsing === 'JOIN' && preg_match('/^CONNECTION ["\'](.+)["\']$/i', $line, $matches)) {
                $join->connection = $matches[1];
            } elseif ($this->parsing === 'JOIN' && preg_match('/^CONNECTIONTYPE (CSV|MYSQL|POSTGRESQL)$/i', $line, $matches)) {
                $join->connectiontype = strtoupper($matches[1]);
            } elseif ($this->parsing === 'JOIN' && preg_match('/^FOOTER ["\'](.+)["\']$/i', $line, $matches)) {
                $join->footer = $matches[1];
            } elseif ($this->parsing === 'JOIN' && preg_match('/^FROM ["\'](.+)["\']$/i', $line, $matches)) {
                $join->from = $matches[1];
            } elseif ($this->parsing === 'JOIN' && preg_match('/^HEADER ["\'](.+)["\']$/i', $line, $matches)) {
                $join->header = $matches[1];
            } elseif ($this->parsing === 'JOIN' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches)) {
                $join->name = $matches[1];
            } elseif ($this->parsing === 'JOIN' && preg_match('/^TABLE ["\'](.+)["\']$/i', $line, $matches)) {
                $join->table = $matches[1];
            } elseif ($this->parsing === 'JOIN' && preg_match('/^TEMPLATE ["\'](.+)["\']$/i', $line, $matches)) {
                $join->template = $matches[1];
            } elseif ($this->parsing === 'JOIN' && preg_match('/^TO ["\'](.+)["\']$/i', $line, $matches)) {
                $join->to = $matches[1];
            } elseif ($this->parsing === 'JOIN' && preg_match('/^TYPE (ONE-TO-ONE|ONE-TO-MANY)$/i', $line, $matches)) {
                $join->type = strtoupper($matches[1]);
            } elseif ($this->parsing === 'JOIN' && preg_match('/^END( # JOIN)?$/i', $line)) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $join;
    }
}
