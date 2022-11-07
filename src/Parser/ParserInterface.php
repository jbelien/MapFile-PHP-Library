<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Parser;

use MapFile\Model\MapFileObject;

interface ParserInterface
{
    public function getCurrentLine(): string;

    /**
     * @param null|string[] $content
     *
     * @return MapFileObject|string|string[]|float[][]
     */
    public function parse(?array $content = null);
}
