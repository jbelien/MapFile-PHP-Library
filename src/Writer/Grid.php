<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Grid extends Writer
{
    public function write($grid, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'GRID'.PHP_EOL;

        $this->text .= self::getTextString('LABELFORMAT', $grid->labelformat, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINARCS', $grid->minarcs, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXARCS', $grid->maxarcs, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MININTERVAL', $grid->mininterval, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXINTERVAL', $grid->maxinterval, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINSUBDIVIDE', $grid->minsubdivide, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXSUBDIVIDE', $grid->maxsubdivide, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # GRID'.PHP_EOL;

        return $this->text;
    }
}
