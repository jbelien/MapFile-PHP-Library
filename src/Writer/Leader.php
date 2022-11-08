<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

use InvalidArgumentException;
use MapFile\Model\Leader as LeaderObject;

class Leader extends Writer
{
    public function writeBlock($leader, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        if (!$leader instanceof LeaderObject) {
            throw new InvalidArgumentException(
                sprintf(
                    'The first argument must be an instance of "Leader", instance of "%s" given.',
                    gettype($leader) === 'object' ? get_class($leader) : gettype($leader)
                )
            );
        }

        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'LEADER'.PHP_EOL;

        $this->text .= self::getTextRaw('GRIDSTEP', $leader->gridstep, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXDISTANCE', $leader->maxdistance, $indentSize + 1, $indent);

        foreach ($leader->style as $style) {
            $this->text .= (new Style())->writeBlock($style, $indentSize + 1, $indent);
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # LEADER'.PHP_EOL;

        return $this->text;
    }
}
