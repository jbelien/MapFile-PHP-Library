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

abstract class Parser implements ParserInterface
{
    protected $content;
    protected $currentLineIndex;
    protected $eof = false;
    protected $file;
    protected $lineEnd;
    protected $lineStart;
    protected $parsing;

    public function __construct(string $file, int $lineNumber = 0)
    {
        if (!file_exists($file)) {
            throw new FileException(
                sprintf('File "%s" does not exist.', $file)
            );
        }
        if (!is_readable($file)) {
            throw new FileException(
                sprintf('File "%s" is not readable.', $file)
            );
        }

        $this->currentLineIndex = $lineNumber;
        $this->file = $file;
        $this->lineStart = $lineNumber;
    }

    public function getCurrentLine(): string
    {
        if ($this->eof === true) {
            throw new OutOfBoundsException();
        }

        if (is_null($this->content)) {
            $this->content = file($this->file);
        }

        $line = $this->content[$this->currentLineIndex];

        $line = trim($line);

        $line = preg_replace('/^#(.+)$/', '', $line);
        $line = preg_replace('/\s*[^"\']#(.+)[^"\']$/', '', $line);

        $line = trim($line);

        $this->currentLineIndex++;

        if ($this->currentLineIndex > count($this->content)) {
            $this->eof = true;
        }

        return $line;
    }

    abstract public function parse($content = null);
}
