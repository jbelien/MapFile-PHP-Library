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
use MapFile\Model\Reference as ReferenceObject;

class Reference
{
    public function parse($content = null): ReferenceObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $reference = new ReferenceObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^REFERENCE$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'REFERENCE';
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^COLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $reference->color = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^COLOR ["\'](#.+)["\']$/i', $line, $matches)) {
                $reference->color = $matches[1];
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^EXTENT (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $reference->extent = [
                    floatval($matches[1]),
                    floatval($matches[2]),
                    floatval($matches[3]),
                    floatval($matches[4]),
                ];
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^IMAGE ["\'](.+)["\']$/i', $line, $matches)) {
                $reference->image = $matches[1];
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^MARKER ([0-9]+)$/i', $line, $matches)) {
                $reference->marker = intval($matches[1]);
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^MARKER ["\'](.+)["\']$/i', $line, $matches)) {
                $reference->marker = $matches[1];
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^MARKERSIZE ([0-9]+)$/i', $line, $matches)) {
                $reference->markersize = intval($matches[1]);
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^MAXBOXSIZE ([0-9]+)$/i', $line, $matches)) {
                $reference->maxboxsize = intval($matches[1]);
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^MINBOXSIZE ([0-9]+)$/i', $line, $matches)) {
                $reference->minboxsize = intval($matches[1]);
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^OUTLINECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $reference->outlinecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^OUTLINECOLOR ["\'](#.+)["\']$/i', $line, $matches)) {
                $reference->outlinecolor = $matches[1];
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^SIZE ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $reference->size = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^STATUS (ON|OFF)$/i', $line, $matches)) {
                $reference->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'REFERENCE' && preg_match('/^END( # REFERENCE)?$/i', $line)) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $reference;
    }
}
