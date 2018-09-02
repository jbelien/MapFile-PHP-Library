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
 * MapFile Generator - Legend (LEGEND) Class.
 * [MapFile LEGEND clause](https://mapserver.org/mapfile/legend.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/legend.html
 */
class Legend
{
    /** @var int[]|string Color to initialize the legend with (i.e. the background). */
    public $imagecolor;
    /** @var int[] Size of symbol key boxes in pixels. */
    public $keysize;
    /** @var int[] Spacing between symbol key boxes ([y]) and labels ([x]) in pixels. */
    public $keyspacing;
    /** @var \MapFile\Model\Label */
    public $label;
    /** @var int[]|string Color to use for outlining symbol key boxes. */
    public $outlinecolor;
    /** @var string Where to place an embedded legend in the map. */
    public $position;
    /** @var bool Tells MapServer to render this legend after all labels in the cache have been drawn. */
    public $postlabelcache;
    /** @var string Is the legend image to be created ? */
    public $status;
    /** @var string HTML legend template file. */
    public $template;

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (is_null($this->label)) {
            $this->label = new Label();
        }
    }
}
