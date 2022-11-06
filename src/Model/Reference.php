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
 * MapFile Generator - Reference (REFERENCE) Class.
 * [MapFile REFERENCE clause](https://mapserver.org/mapfile/reference.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/reference.html
 */
class Reference extends MapFileObject
{
    /** @var null|int[]|string Color in which the reference box is drawn. */
    public $color;
    /** @var null|float[] The spatial extent of the base reference image. */
    public $extent;
    /** @var null|string Full filename of the base reference image. */
    public $image;
    /** @var null|int|string Defines a symbol (from the symbol file) to use when the box becomes too small. */
    public $marker;
    /** @var null|int Defines the size of the symbol to use instead of a box */
    public $markersize;
    /** @var null|int If box is smaller than MINBOXSIZE (use box width or height) then use the symbol defined by MARKER and MARKERSIZE. */
    public $minboxsize;
    /** @var null|int If box is greater than MAXBOXSIZE (use box width or height) then draw nothing. */
    public $maxboxsize;
    /** @var null|int[]|string Color to use for outlining the reference box. */
    public $outlinecolor;
    /** @var null|int[] Size, in pixels, of the base reference image. */
    public $size;
    /** @var null|string Is the reference map to be created ? */
    public $status;
}
