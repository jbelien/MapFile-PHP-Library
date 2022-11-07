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
 * MapFile Generator - Leader (LEADER) Class.
 * [MapFile LEADER clause](https://mapserver.org/mapfile/leader.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/leader.html
 */
class Leader extends MapFileObject
{
    /** @var null|int Specifies the number of pixels between positions that are tested for a label line. */
    public $gridstep;
    /** @var null|int Specifies the maximum distance in pixels from the normal label location that a leader line can be drawn. */
    public $maxdistance;
    /** @var ArrayCollection<int,Style> */
    public $style;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->style = new ArrayCollection();
    }
}
