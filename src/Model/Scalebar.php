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
class Scalebar extends MapFileObject
{
    /**
     * @var null|string Defines how the scalebar is aligned within the scalebar image.
     * @version 5.2
     */
    public $align;
    /** @var null|int[]|string Color to use for scalebar background, not the image background. */
    public $backgroundcolor;
    /** @var null|int[]|string Color to use for drawing all features if attribute tables are not used. */
    public $color;
    /** @var null|int[]|string Color to initialize the scalebar with (i.e. background). */
    public $imagecolor;
    /** @var null|int Number of intervals to break the scalebar into. */
    public $intervals;
    /** @var null|Label */
    public $label;
    /**
     * @var null|int[] OFFSET moves the scalebar closer to the center of the map.
     * @version 7.2
     */
    public $offset;
    /** @var null|int[]|string Color to use for outlining individual intervals. */
    public $outlinecolor;
    /** @var null|string Where to place an embedded scalebar in the image. */
    public $position;
    /** @var null|bool Tells the MapServer to embed the scalebar after all labels in the cache have been drawn. */
    public $postlabelcache;
    /** @var null|int[] Size in pixels of the scalebar. */
    public $size;
    /** @var null|string Is the scalebar image to be created, and if so should it be embedded into the image ? */
    public $status;
    /** @var null|int Chooses the scalebar style. */
    public $style;
    /** @var null|string Output scalebar units. */
    public $units;
}
