<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Leader extends Writer
{
    public function write($leader, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'LEADER'.PHP_EOL;

        $this->text .= self::getTextRaw('GRIDSTEP', $leader->gridstep, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXDISTANCE', $leader->maxdistance, $indentSize + 1, $indent);

        foreach ($leader->style as $style) {
            $this->text .= (new Style())->write($style, $indentSize + 1, $indent);
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # LEADER'.PHP_EOL;

        return $this->text;
    }
}
