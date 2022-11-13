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
 * MapFile Generator - Label (LABEL) Class.
 * [MapFile LABEL clause](https://mapserver.org/mapfile/label.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/label.html
 */
class Label extends MapFileObject
{
    /**
     * @var null|string Text alignment for multiline labels.
     * @version 5.4
     */
    public $align;
    /** @var null|float|string */
    public $angle;
    /**
     * @var null|bool Should text be antialiased ?
     * @deprecated 7.0
     */
    public $antialias;
    /** @var null|int Padding, in pixels, around labels. */
    public $buffer;
    /** @var null|int[]|string Color to draw text with. */
    public $color;
    /**
     * @var null|string Expression that determines when the LABEL is to be applied.
     * @version 6.2
     */
    public $expression;
    /** @var null|string */
    public $font;
    /** @var null|bool Forces labels for a particular class on, regardless of collisions. */
    public $force;
    /**
     * @var null|int This keyword interacts with the WRAP keyword so that line breaks only occur after the defined number of characters.
     * @version 5.4
     */
    public $maxlength;
    /** @var null|float Angle threshold to use in filtering out ANGLE FOLLOW labels in which characters overlap (floating point value in degrees). */
    public $maxoverlapangle;
    /**
     * @var null|float Maximum scale denominator.
     * @version 5.4
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /** @var null|float Maximum font size to use when scaling text (pixels). */
    public $maxsize;
    /** @var null|int Minimum distance between duplicate labels. */
    public $mindistance;
    /** @var null|int|string Minimum size a feature must be to be labeled. */
    public $minfeaturesize;
    /**
     * @var null|float Minimum scale denominator.
     * @version 5.4
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /** @var null|float Minimum font size to use when scaling text (pixels). */
    public $minsize;
    /** @var null|int[] Offset values for labels, relative to the lower left hand corner of the label and the label point. */
    public $offset;
    /** @var null|int[]|string Color to draw a one pixel outline around the characters in the text. */
    public $outlinecolor;
    /** @var null|int Width of the outline if OUTLINECOLOR has been set. */
    public $outlinewidth;
    /** @var null|bool Can text run off the edge of the map ? */
    public $partials;
    /** @var null|string Position of the label relative to the labeling point. */
    public $position;
    /**
     * @var null|string|int The priority parameter takes an integer value between 1 (lowest) and 10 (highest).
     * @version 5.0
     */
    public $priority;
    /**
     * @var null|int The label will be repeated on every line of a multiline shape and will be repeated multiple times along a given line at an interval of REPEATDISTANCE pixels.
     * @version 5.0
     */
    public $repeatdistance;
    /** @var null|int[]|string Color of drop shadow. */
    public $shadowcolor;
    /** @var null|array<int|string> Shadow offset in pixels. */
    public $shadowsize;
    /** @var null|string|int Text size. */
    public $size;
    /** @var ArrayCollection<int,Style> */
    public $style;
    /**
     * @var null|string Text to label features with.
     * @version 6.0
     */
    public $text;
    /** @var null|string Type of font to use. */
    public $type;
    /** @var null|string Character that represents an end-of-line condition in label text, thus resulting in a multi-line label. */
    public $wrap;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->style = new ArrayCollection();
    }
}
