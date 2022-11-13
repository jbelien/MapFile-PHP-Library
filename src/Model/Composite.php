<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * MapFile Generator - Composite (COMPOSITE) Class.
 * [MapFile COMPOSITE clause](https://mapserver.org/mapfile/composite.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/composite.html
 */
class Composite extends MapFileObject
{
    /**
     * @var string[] Name of the compositing filter.
     * @version 7.2
     */
    public $compfilter = [];
    /** @var null|string Name of the compositing operator to use when blending the temporary image onto the main map image. */
    public $compop;
    /** @var null|int Sets the opacity level (or the inability to see through the layer) of all classed pixels for a given layer. */
    public $opacity;
}
