<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

interface WriterInterface
{
    public function save(): bool;

    public function write($object, int $indentSize = 0, string $indent = self::WRITER_INDENT);
}
