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
    public function parseBlock(?array $content = null): WebObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $web = new WebObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^WEB$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'WEB';
            } elseif ($this->parsing === 'WEB' && preg_match('/^BROWSEFORMAT ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->browseformat = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^EMPTY ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->empty = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^ERROR ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->error = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^FOOTER ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->footer = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^HEADER ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->header = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^IMAGEPATH ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->imagepath = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^IMAGEURL ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->imageurl = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^LEGENDFORMAT ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->legendformat = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^MAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $web->maxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'WEB' && preg_match('/^MAXTEMPLATE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->maxtemplate = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^METADATA$/i', $line) === 1) {
                $metadataParser = new Metadata($this->file, $this->currentLineIndex - 1);
                $metadata = $metadataParser->parseBlock();

                $web->metadata = $metadata;

                $this->currentLineIndex = $metadataParser->lineEnd;
            } elseif ($this->parsing === 'WEB' && preg_match('/^MINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $web->minscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'WEB' && preg_match('/^MINTEMPLATE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->mintemplate = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^QUERYFORMAT ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->queryformat = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^TEMPLATE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->template = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^TEMPPATH ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $web->temppath = $matches[1];
            } elseif ($this->parsing === 'WEB' && preg_match('/^VALIDATION$/i', $line) === 1) {
                $validationParser = new Validation($this->file, $this->currentLineIndex - 1);
                $validation = $validationParser->parseBlock();

                $web->validation = $validation;

                $this->currentLineIndex = $validationParser->lineEnd;
            } elseif ($this->parsing === 'WEB' && preg_match('/^END( # WEB)?$/i', $line) === 1) {
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
