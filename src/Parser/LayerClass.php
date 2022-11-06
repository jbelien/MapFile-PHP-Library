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
    public function parse($content = null): LayerClassObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $class = new LayerClassObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^CLASS$/i', $line) !== false) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'CLASS';
            } elseif ($this->parsing === 'CLASS' && preg_match('/^DEBUG (ON|OFF)$/i', $line, $matches) !== false) {
                $class->debug = strtoupper($matches[1]);
            } elseif ($this->parsing === 'CLASS' && preg_match('/^EXPRESSION ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $class->expression = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^EXPRESSION (\(.+\))$/i', $line, $matches) !== false) {
                $class->expression = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^EXPRESSION (\{.+\})$/i', $line, $matches) !== false) {
                $class->expression = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^EXPRESSION (\/.+\/[a-z]*)$/i', $line, $matches) !== false) {
                $class->expression = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^GROUP ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $class->group = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^KEYIMAGE ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $class->keyimage = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^LABEL$/i', $line) !== false) {
                $labelParser = new Label($this->file, $this->currentLineIndex - 1);
                $label = $labelParser->parse();

                $class->label->add($label);

                $this->currentLineIndex = $labelParser->lineEnd;
            } elseif ($this->parsing === 'CLASS' && preg_match('/^LEADER$/i', $line) !== false) {
                $leaderParser = new Leader($this->file, $this->currentLineIndex - 1);
                $leader = $leaderParser->parse();

                $class->leader = $leader;

                $this->currentLineIndex = $leaderParser->lineEnd;
            } elseif ($this->parsing === 'CLASS' && preg_match('/^MAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) !== false) {
                $class->maxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'CLASS' && preg_match('/^MINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) !== false) {
                $class->minscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'CLASS' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $class->name = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^STATUS (ON|OFF)$/i', $line, $matches) !== false) {
                $class->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'CLASS' && preg_match('/^STYLE$/i', $line) !== false) {
                $styleParser = new Style($this->file, $this->currentLineIndex - 1);
                $style = $styleParser->parse();

                $class->style->add($style);

                $this->currentLineIndex = $styleParser->lineEnd;
            } elseif ($this->parsing === 'CLASS' && preg_match('/^TEMPLATE ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $class->template = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^TEXT ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $class->text = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^TEXT (\(.+\))$/i', $line, $matches) !== false) {
                $class->text = $matches[1];
            } elseif ($this->parsing === 'CLASS' && preg_match('/^VALIDATION$/i', $line) !== false) {
                $validationParser = new Validation($this->file, $this->currentLineIndex - 1);
                $validation = $validationParser->parse();

                $class->validation = $validation;

                $this->currentLineIndex = $validationParser->lineEnd;
            } elseif ($this->parsing === 'CLASS' && preg_match('/^END( # CLASS)?$/i', $line) !== false) {
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
