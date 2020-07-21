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
use MapFile\Model\Web as WebObject;

class Web extends Parser
{
    public function parse($content = null): WebObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $web = new WebObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^WEB$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'WEB';
            } elseif ($this->parsing === 'WEB' && preg_match('/^BROWSEFORMAT ["\'](.+)["\']$/i', $line, $matches)) {
                $web->browseformat = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^EMPTY ["\'](.+)["\']$/i', $line, $matches)) {
                $web->empty = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^ERROR ["\'](.+)["\']$/i', $line, $matches)) {
                $web->error = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^FOOTER ["\'](.+)["\']$/i', $line, $matches)) {
                $web->footer = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^HEADER ["\'](.+)["\']$/i', $line, $matches)) {
                $web->header = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^IMAGEPATH ["\'](.+)["\']$/i', $line, $matches)) {
                $web->imagepath = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^IMAGEURL ["\'](.+)["\']$/i', $line, $matches)) {
                $web->imageurl = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^LEGENDFORMAT ["\'](.+)["\']$/i', $line, $matches)) {
                $web->legendformat = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^MAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $web->maxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'WEB' && preg_match('/^MAXTEMPLATE ["\'](.+)["\']$/i', $line, $matches)) {
                $web->maxtemplate = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^METADATA$/i', $line)) {
                $metadataParser = new Metadata($this->file, $this->currentLineIndex - 1);
                $metadata = $metadataParser->parse();

                $web->metadata = $metadata;

                $this->currentLineIndex = $metadataParser->lineEnd;
            } elseif ($this->parsing === 'WEB' && preg_match('/^MINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $web->minscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'WEB' && preg_match('/^MINTEMPLATE ["\'](.+)["\']$/i', $line, $matches)) {
                $web->mintemplate = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^QUERYFORMAT ["\'](.+)["\']$/i', $line, $matches)) {
                $web->queryformat = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^TEMPLATE ["\'](.+)["\']$/i', $line, $matches)) {
                $web->template = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^TEMPPATH ["\'](.+)["\']$/i', $line, $matches)) {
                $web->temppath = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^VALIDATION$/i', $line)) {
                $validationParser = new Validation($this->file, $this->currentLineIndex - 1);
                $validation = $validationParser->parse();

                $web->validation = $validation;

                $this->currentLineIndex = $validationParser->lineEnd;
            } elseif ($this->parsing === 'WEB' && preg_match('/^END( # WEB)?$/i', $line)) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $web;
    }
}
