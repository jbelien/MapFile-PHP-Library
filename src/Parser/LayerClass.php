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
use MapFile\Model\LayerClass as LayerClassObject;

class LayerClass extends Parser
{
    public function parse(string $filename, int $lineNumber = 0): LayerClassObject
    {
        parent::parse($filename, $lineNumber);

        $class = new LayerClassObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^CLASS$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'CLASS';
            } elseif ($this->parsing === 'CLASS' && preg_match('/^DEBUG (ON|OFF)$/i', $line, $matches) === 1) {
                $class->debug = strtoupper($matches[1]);
            } elseif ($this->parsing === 'CLASS' && preg_match('/^EXPRESSION ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $class->expression = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^EXPRESSION (\(.+\))$/i', $line, $matches) === 1) {
                $class->expression = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^EXPRESSION (\{.+\})$/i', $line, $matches) === 1) {
                $class->expression = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^EXPRESSION (\/.+\/[a-z]*)$/i', $line, $matches) === 1) {
                $class->expression = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^GROUP ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $class->group = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^KEYIMAGE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $class->keyimage = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^LABEL$/i', $line) === 1) {
                $labelParser = new Label();

                $class->label->add($labelParser->parse($this->file, $this->currentLineIndex - 1));

                $this->currentLineIndex = $labelParser->lineEnd;
            } elseif ($this->parsing === 'CLASS' && preg_match('/^LEADER$/i', $line) === 1) {
                $leaderParser = new Leader();

                $class->leader = $leaderParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $leaderParser->lineEnd;
            } elseif ($this->parsing === 'CLASS' && preg_match('/^MAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $class->maxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'CLASS' && preg_match('/^MINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $class->minscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'CLASS' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $class->name = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^STATUS (ON|OFF)$/i', $line, $matches) === 1) {
                $class->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'CLASS' && preg_match('/^STYLE$/i', $line) === 1) {
                $styleParser = new Style();

                $class->style->add($styleParser->parse($this->file, $this->currentLineIndex - 1));

                $this->currentLineIndex = $styleParser->lineEnd;
            } elseif ($this->parsing === 'CLASS' && preg_match('/^TEMPLATE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $class->template = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^TEXT ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $class->text = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^TEXT (\(.+\))$/i', $line, $matches) === 1) {
                $class->text = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^VALIDATION$/i', $line) === 1) {
                $validationParser = new Validation();

                $class->validation = $validationParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $validationParser->lineEnd;
            } elseif ($this->parsing === 'CLASS' && preg_match('/^END( # CLASS)?$/i', $line) === 1) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $class;
    }
}
