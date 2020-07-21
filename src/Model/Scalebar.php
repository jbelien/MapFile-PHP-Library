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
 * MapFile Generator - Scalebar (SCALEBAR) Class.
 * [MapFile SCALEBAR clause](https://mapserver.org/mapfile/scalebar.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/scalebar.html
 */
class Scalebar
{
    /** @var string Defines how the scalebar is aligned within the scalebar image. */
    public $align;
    /** @var int[]|string Color to use for scalebar background, not the image background. */
    public $backgroundcolor;
    /** @var int[]|string Color to use for drawing all features if attribute tables are not used. */
    public $color;
    /** @var int[]|string Color to initialize the scalebar with (i.e. background). */
    public $imagecolor;
    /** @var int Number of intervals to break the scalebar into. */
    public $intervals;
    /** @var \MapFile\Model\Label */
    public $label;
    /** @var int[] OFFSET moves the scalebar closer to the center of the map. */
    public $offset;
    /** @var int[]|string Color to use for outlining individual intervals. */
    public $outlinecolor;
    /** @var string Where to place an embedded scalebar in the image. */
    public $position;
    /** @var bool Tells the MapServer to embed the scalebar after all labels in the cache have been drawn. */
    public $postlabelcache;
    /** @var int[] Size in pixels of the scalebar. */
    public $size;
    /** @var string Is the scalebar image to be created, and if so should it be embedded into the image ? */
    public $status;
    /** @var int Chooses the scalebar style. */
    public $style;
    /** @var string Output scalebar units. */
    public $units;
}
