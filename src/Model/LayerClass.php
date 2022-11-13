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
 * MapFile Generator - LayerClass (CLASS) Class.
 * [MapFile CLASS clause](https://mapserver.org/mapfile/class.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/class.html
 */
class LayerClass extends MapFileObject
{
    /** @var null|string Enables debugging of the class object. */
    public $debug;
    /** @var null|string Defines which class a feature belongs to. */
    public $expression;
    /** @var null|string Allows for grouping of classes. */
    public $group;
    /** @var null|string Full filename of the legend image for the CLASS. */
    public $keyimage;
    /** @var ArrayCollection<int,Label> */
    public $label;
    /**
     * @var null|Leader
     *
     * @version 6.2
     */
    public $leader;
    /**
     * @var null|float Minimum scale at which this CLASS is drawn.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /**
     * @var null|float Maximum scale at which this CLASS is drawn.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /** @var null|string Name to use in legends for this class. */
    public $name;
    /** @var null|string Sets the current display status of the class. */
    public $status;
    /** @var ArrayCollection<int,Style> */
    public $style;
    /** @var null|string Template file or URL to use in presenting query results to the user. */
    public $template;
    /** @var null|string Text to label features in this class with. */
    public $text;
    /** @var null|array<string,string> */
    public $validation;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->label = new ArrayCollection();
        $this->style = new ArrayCollection();
    }
}
