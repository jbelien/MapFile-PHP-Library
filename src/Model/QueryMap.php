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
 * MapFile Generator - QueryMap (QUERYMAP) Class.
 * [MapFile QUERYMAP clause](https://mapserver.org/mapfile/querymap.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/querymap.html
 */
class QueryMap extends MapFileObject
{
    /** @var null|int[]|string Color in which features are highlighted. */
    public $color;
    /** @var null|int[] Size of the map in pixels. */
    public $size;
    /** @var null|string Is the query map to be drawn? */
    public $status;
    /** @var null|string Sets how selected features are to be handled. */
    public $style;
}
