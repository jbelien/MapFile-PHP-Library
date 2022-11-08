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
use MapFile\Model\MapFileObject;
use OutOfBoundsException;

abstract class Parser
{
    /** @var null|string[] */
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
            $content = file($this->file);

            if ($content === false) {
                throw new FileException(
                    sprintf('File "%s" is not parsable.', $this->file)
                );
            }

            $this->content = $content;
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

    /**
     * @param null|string[] $content
     *
     * @return MapFileObject|string|string[]|float[][]
     */
    abstract public function parseBlock(?array $content = null);
}
