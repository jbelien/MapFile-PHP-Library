<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Model;

/**
 * MapFile Generator - ScaleToken (SCALETOKEN) Class.
 *
 * @author Jonathan Beliën
 */
class ScaleToken extends MapFileObject
{
    /** @var null|string */
    public $name;
    /** @var array<string,string> */
    public $values = [];
}
