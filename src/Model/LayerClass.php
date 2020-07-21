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
class LayerClass
{
    /** @var string Enables debugging of the class object. */
    public $debug;
    /** @var string Defines which class a feature belongs to. */
    public $expression;
    /** @var string Allows for grouping of classes. */
    public $group;
    /** @var string Full filename of the legend image for the CLASS. */
    public $keyimage;
    /** @var \Doctrine\Common\Collections\ArrayCollection */
    public $label;
    /** @var \MapFile\Model\Leader */
    public $leader;
    /**
     * @var float Minimum scale at which this CLASS is drawn.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /**
     * @var float Maximum scale at which this CLASS is drawn.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /** @var string Name to use in legends for this class. */
    public $name;
    /** @var string Sets the current display status of the class. */
    public $status;
    /** @var \Doctrine\Common\Collections\ArrayCollection */
    public $style;
    /** @var string Template file or URL to use in presenting query results to the user. */
    public $template;
    /** @var string Text to label features in this class with. */
    public $text;
    /** @var string[] */
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
