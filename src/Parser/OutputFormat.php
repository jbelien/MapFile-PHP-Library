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
use MapFile\Model\OutputFormat as OutputFormatObject;

class OutputFormat extends Parser
{
    public function parse($content = null): OutputFormatObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $outputformat = new OutputFormatObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^OUTPUTFORMAT$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'OUTPUTFORMAT';
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^DRIVER (.+)$/i', $line, $matches)) {
                $outputformat->driver = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^EXTENSION ["\'](.+)["\']$/i', $line, $matches)) {
                $outputformat->extension = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^FORMATOPTION ["\'](.+)["\']$/i', $line, $matches)) {
                $outputformat->formatoption[] = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^IMAGEMODE (PC256|RGB|RGBA|INT16|FLOAT32|FEATURE)$/i', $line, $matches)) {
                $outputformat->imagemode = strtoupper($matches[1]);
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^MIMETYPE ["\'](.+)["\']$/i', $line, $matches)) {
                $outputformat->mimetype = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches)) {
                $outputformat->name = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^TRANSPARENT (ON|OFF)$/i', $line, $matches)) {
                $outputformat->transparent = strtoupper($matches[1]);
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^END( # OUTPUTFORMAT)?$/i', $line)) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $outputformat;
    }
}
