<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Parser;

use MapFile\Exception\FileException;
use OutOfBoundsException;

abstract class Parser
{
    /** @var array<int,string> */
    protected $content;
    /** @var int */
    protected $currentLineIndex;
    /** @var bool */
    protected $eof = false;
    /** @var string */
    protected $file;
    /** @var int */
    protected $lineEnd;
    /** @var int */
    protected $lineStart;
    /** @var null|string */
    protected $parsing;

    /**
     * @param string $filename
     * @param int    $lineNumber
     *
     * @throws FileException
     *
     * @return void
     */
    public function parse(string $filename, int $lineNumber = 0)
    {
        if (!file_exists($filename)) {
            throw new FileException(
                sprintf('File "%s" does not exist.', $filename)
            );
        }
        if (!is_readable($filename)) {
            throw new FileException(
                sprintf('File "%s" is not readable.', $filename)
            );
        }

        $this->file = $filename;
        $this->currentLineIndex = $lineNumber;
        $this->lineStart = $lineNumber;

        $content = file($this->file);

        if ($content === false) {
            throw new FileException(
                sprintf('File "%s" is not parsable.', $this->file)
            );
        }

        $this->content = $content;
    }

    protected function getCurrentLine(): string
    {
        if ($this->eof === true) {
            throw new OutOfBoundsException();
        }

        $line = $this->content[$this->currentLineIndex];

        $line = trim($line);

        /** @var string */
        $line = preg_replace('/^#(.+)$/', '', $line);
        /** @var string */
        $line = preg_replace('/\s*[^"\']#(.+)[^"\']$/', '', $line);

        $line = trim($line);

        $this->currentLineIndex++;

        if ($this->currentLineIndex > count($this->content)) {
            $this->eof = true;
        }

        return $line;
    }
}
