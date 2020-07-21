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
class Grid
{
    /** @var string Format of the label. “DD” for degrees, “DDMM” for degrees minutes, and “DDMMSS” for degrees, minutes, seconds. */
    public $labelformat;
    /** @var float The minimum number of arcs to draw. */
    public $minarcs;
    /** @var float The maximum number of arcs to draw. */
    public $maxarcs;
    /** @var float The minimum number of intervals to try to use. */
    public $mininterval;
    /** @var float The maximum number of intervals to try to use. */
    public $maxinterval;
    /** @var float The minimum number of segments to use when rendering an arc. */
    public $minsubdivide;
    /** @var float The maximum number of segments to use when rendering an arc. */
    public $maxsubdivide;
}
