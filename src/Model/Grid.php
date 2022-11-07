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
 * MapFile Generator - Grid (GRID) Class.
 * [MapFile GRID clause](https://mapserver.org/mapfile/grid.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/grid.html
 */
class Grid extends MapFileObject
{
    /** @var null|string Format of the label. “DD” for degrees, “DDMM” for degrees minutes, and “DDMMSS” for degrees, minutes, seconds. */
    public $labelformat;
    /** @var null|float The minimum number of arcs to draw. */
    public $minarcs;
    /** @var null|float The maximum number of arcs to draw. */
    public $maxarcs;
    /** @var null|float The minimum number of intervals to try to use. */
    public $mininterval;
    /** @var null|float The maximum number of intervals to try to use. */
    public $maxinterval;
    /** @var null|float The minimum number of segments to use when rendering an arc. */
    public $minsubdivide;
    /** @var null|float The maximum number of segments to use when rendering an arc. */
    public $maxsubdivide;
}
