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
    public function parse(?array $content = null): OutputFormatObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $outputformat = new OutputFormatObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^OUTPUTFORMAT$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'OUTPUTFORMAT';
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^DRIVER (.+)$/i', $line, $matches) === 1) {
                $outputformat->driver = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^EXTENSION ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $outputformat->extension = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^FORMATOPTION ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $outputformat->formatoption[] = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^IMAGEMODE (PC256|RGB|RGBA|INT16|FLOAT32|FEATURE)$/i', $line, $matches) === 1) {
                $outputformat->imagemode = strtoupper($matches[1]);
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^MIMETYPE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $outputformat->mimetype = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $outputformat->name = $matches[1];
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^TRANSPARENT (ON|OFF)$/i', $line, $matches) === 1) {
                $outputformat->transparent = strtoupper($matches[1]);
            } elseif ($this->parsing === 'OUTPUTFORMAT' && preg_match('/^END( # OUTPUTFORMAT)?$/i', $line) === 1) {
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
