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
 * MapFile Generator - Label (LABEL) Class.
 * [MapFile LABEL clause](https://mapserver.org/mapfile/label.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/label.html
 */
class Label
{
    /** @var string Text alignment for multiline labels. */
    public $align;
    /** @var float|string */
    public $angle;
    /** @var bool Should text be antialiased ? */
    public $antialias;
    /** @var int Padding, in pixels, around labels. */
    public $buffer;
    /** @var int[]|string Color to draw text with. */
    public $color;
    /** @var string Expression that determines when the LABEL is to be applied. */
    public $expression;
    /** @var string */
    public $font;
    /** @var bool Forces labels for a particular class on, regardless of collisions. */
    public $force;
    /** @var int This keyword interacts with the WRAP keyword so that line breaks only occur after the defined number of characters. */
    public $maxlength;
    /** @var float Angle threshold to use in filtering out ANGLE FOLLOW labels in which characters overlap (floating point value in degrees). */
    public $maxoverlapangle;
    /**
     * @var float Maximum scale denominator.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /** @var float Maximum font size to use when scaling text (pixels). */
    public $maxsize;
    /** @var int Minimum distance between duplicate labels. */
    public $mindistance;
    /** @var int|string Minimum size a feature must be to be labeled. */
    public $minfeaturesize;
    /**
     * @var float Minimum scale denominator.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /** @var float Minimum font size to use when scaling text (pixels). */
    public $minsize;
    /** @var int[] Offset values for labels, relative to the lower left hand corner of the label and the label point. */
    public $offset;
    /** @var int[]|string Color to draw a one pixel outline around the characters in the text. */
    public $outlinecolor;
    /** @var int Width of the outline if OUTLINECOLOR has been set. */
    public $outlinewidth;
    /** @var bool Can text run off the edge of the map ? */
    public $partials;
    /** @var string Position of the label relative to the labeling point. */
    public $position;
    /** @var string|int The priority parameter takes an integer value between 1 (lowest) and 10 (highest). */
    public $priority;
    /** @var int The label will be repeated on every line of a multiline shape and will be repeated multiple times along a given line at an interval of REPEATDISTANCE pixels. */
    public $repeatdistance;
    /** @var int[]|string Color of drop shadow. */
    public $shadowcolor;
    /** @var array Shadow offset in pixels. */
    public $shadowsize;
    /** @var string|int Text size. */
    public $size;
    /** @var \MapFile\Model\Style */
    public $style;
    /** @var string Text to label features with. */
    public $text;
    /** @var string Type of font to use. */
    public $type;
    /** @var string Character that represents an end-of-line condition in label text, thus resulting in a multi-line label. */
    public $wrap;
}
