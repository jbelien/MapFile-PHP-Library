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
 * [MapFile Layer SCALETOKEN clause](https://mapserver.org/mapfile/layer.html#mapfile-layer-scaletoken).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/layer.html#mapfile-layer-scaletoken
 */
class ScaleToken extends MapFileObject
{
    /** @var null|string */
    public $name;
    /** @var array<int|string,string> */
    public $values = [];
}
