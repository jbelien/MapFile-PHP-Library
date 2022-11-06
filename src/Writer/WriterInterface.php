<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

use MapFile\Model\MapFileObject;

interface WriterInterface
{
    const WRITER_INDENT = '  ';

    public function save(): bool;

    /**
     * @param MapFileObject|string|array<string,string>|array<array<float>> $object
     * @param int $indentSize
     * @param string $indent
     * @return string
     */
    public function write($object, int $indentSize = 0, string $indent = self::WRITER_INDENT): string;
}
