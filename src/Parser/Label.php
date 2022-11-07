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
use MapFile\Model\Label as LabelObject;

class Label extends Parser
{
    public function parse(?array $content = null): LabelObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $label = new LabelObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^LABEL$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'LABEL';
            } elseif ($this->parsing === 'LABEL' && preg_match('/^ALIGN (LEFT|CENTER|RIGHT)$/i', $line, $matches) === 1) {
                $label->align = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^ANGLE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $label->angle = floatval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^ANGLE (AUTO|AUTO2|FOLLOW)$/i', $line, $matches) === 1) {
                $label->angle = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^ANGLE (\[.+\])$/i', $line, $matches) === 1) {
                $label->angle = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^ANTIALIAS (TRUE|FALSE)$/i', $line, $matches) === 1) {
                $label->antialias = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'LABEL' && preg_match('/^BUFFER ([0-9]+)$/i', $line, $matches) === 1) {
                $label->buffer = intval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^COLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $label->color = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^COLOR ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $label->color = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^COLOR (\[.+\])$/i', $line, $matches) === 1) {
                $label->color = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^EXPRESSION (\(.+\))$/i', $line, $matches) === 1) {
                $label->expression = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^EXPRESSION (\{.+\})$/i', $line, $matches) === 1) {
                $label->expression = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^EXPRESSION (\/.+\/[a-z]*)$/i', $line, $matches) === 1) {
                $label->expression = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^FONT ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $label->font = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^FONT (.+)$/i', $line, $matches) === 1) {
                $label->font = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^FONT (\[.+\])$/i', $line, $matches) === 1) {
                $label->font = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^FORCE (TRUE|FALSE)$/i', $line, $matches) === 1) {
                $label->force = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'LABEL' && preg_match('/^MAXLENGTH ([0-9]+)$/i', $line, $matches) === 1) {
                $label->maxlength = intval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^MAXOVERLAPANGLE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $label->maxoverlapangle = floatval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^MAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $label->maxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^MAXSIZE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $label->maxsize = floatval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^MINDISTANCE ([0-9]+)$/i', $line, $matches) === 1) {
                $label->mindistance = intval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^MINFEATURESIZE ([0-9]+)$/i', $line, $matches) === 1) {
                $label->minfeaturesize = intval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^MINFEATURESIZE (AUTO)$/i', $line, $matches) === 1) {
                $label->minfeaturesize = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^MINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $label->minscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^MINSIZE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $label->minsize = floatval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^OFFSET ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $label->offset = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^OUTLINECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $label->outlinecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^OUTLINECOLOR ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $label->outlinecolor = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^OUTLINECOLOR (\[.+\])$/i', $line, $matches) === 1) {
                $label->outlinecolor = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^OUTLINEWIDTH ([0-9]+)$/i', $line, $matches) === 1) {
                $label->outlinewidth = intval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^PARTIALS (TRUE|FALSE)$/i', $line, $matches) === 1) {
                $label->partials = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'LABEL' && preg_match('/^POSITION (UL|UC|UR|CL|CC|CR|LL|LC|LR|AUTO)$/i', $line, $matches) === 1) {
                $label->position = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^PRIORITY ([0-9]+)$/i', $line, $matches) === 1) {
                $label->priority = intval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^PRIORITY (\[.+\])$/i', $line, $matches) === 1) {
                $label->priority = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^REPEATDISTANCE ([0-9]+)$/i', $line, $matches) === 1) {
                $label->repeatdistance = intval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^SHADOWCOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $label->shadowcolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^SHADOWCOLOR ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $label->shadowcolor = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^SHADOWSIZE ([0-9]+|\[.+\]) ([0-9]+|\[.+\])$$/i', $line, $matches) === 1) {
                $label->shadowsize = [
                    is_numeric($matches[1]) ? intval($matches[1]) : $matches[1],
                    is_numeric($matches[2]) ? intval($matches[2]) : $matches[2],
                ];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^SIZE ([0-9]+)$/i', $line, $matches) === 1) {
                $label->size = intval($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^SIZE (TINY|SMALL|MEDIUM|LARGE|GIANT)$/i', $line, $matches) === 1) {
                $label->size = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^SIZE (\[.+\])$/i', $line, $matches) === 1) {
                $label->size = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^STYLE$/i', $line) === 1) {
                $styleParser = new Style($this->file, $this->currentLineIndex - 1);
                $style = $styleParser->parse();

                $label->style->add($style);

                $this->currentLineIndex = $styleParser->lineEnd;
            } elseif ($this->parsing === 'LABEL' && preg_match('/^TEXT ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $label->text = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^TEXT (\(.+\))$/i', $line, $matches) === 1) {
                $label->text = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^TYPE (BITMAP|TRUETYPE)$/i', $line, $matches) === 1) {
                $label->type = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LABEL' && preg_match('/^WRAP ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $label->wrap = $matches[1];
            } elseif ($this->parsing === 'LABEL' && preg_match('/^END( # LABEL)?$/i', $line) === 1) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $label;
    }
}
