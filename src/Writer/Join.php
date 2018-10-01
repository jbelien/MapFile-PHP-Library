<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Join extends Writer
{
    public function write($join, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'JOIN'.PHP_EOL;

        $this->text .= self::getTextString('CONNECTION', $join->connection, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('CONNECTIONTYPE', $join->connectiontype, $indentSize + 1, $indent);
        $this->text .= self::getTextString('FOOTER', $join->footer, $indentSize + 1, $indent);
        $this->text .= self::getTextString('FROM', $join->from, $indentSize + 1, $indent);
        $this->text .= self::getTextString('HEADER', $join->header, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $join->name, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TABLE', $join->table, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TEMPLATE', $join->template, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TO', $join->to, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TYPE', $join->type, $indentSize + 1, $indent);

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # JOIN'.PHP_EOL;

        return $this->text;
    }
}
