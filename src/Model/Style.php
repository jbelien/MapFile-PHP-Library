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
 * MapFile Generator - Style (STYLE) Class.
 * [MapFile STYLE clause](https://mapserver.org/mapfile/style.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/style.html
 */
class Style extends MapFileObject
{
    /** @var null|float|string Angle, given in degrees, to rotate the symbol (counter clockwise). */
    public $angle;
    /**
     * @var null|bool Should TrueType fonts be antialiased.
     * @deprecated 8.0
     */
    public $antialias;
    /** @var null|int[]|string Color to use for drawing features. */
    public $color;
    /** @var null|int[]|string[] Defines two colors to correspond to the low and high ends of the DATARANGE values. */
    public $colorrange;
    /** @var null|int[]|float[] Defines two values, a low value and a high value, that Mapserver will map to the color range defined by the COLORRANGE entry. */
    public $datarange;
    /**
     * @var null|float GAP specifies the distance between SYMBOLs (center to center) for decorated lines and polygon fills in layer SIZEUNITS.
     * @version 6.0
     */
    public $gap;
    /**
     * @var null|string Used to indicate that the current feature will be transformed before the actual style is applied.
     *
     * @see https://mapserver.org/mapfile/geomtransform.html
     */
    public $geomtransform;
    /**
     * @var null|float INITIALGAP is useful for styling dashed lines.
     * @version 6.2
     */
    public $initialgap;
    /**
     * @var null|string Sets the line cap type for lines.
     * @version 6.0
     */
    public $linecap;
    /**
     * @var null|string Sets the line join type for lines.
     * @version 6.0
     */
    public $linejoin;
    /**
     * @var null|int Sets the max length of the miter LINEJOIN type.
     * @version 6.0
     */
    public $linejoinmaxsize;
    /**
     * @var null|float Minimum scale at which this STYLE is drawn.
     * @version 5.4
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /**
     * @var null|float Maximum size in pixels to draw a symbol.
     * @deprecated 8.0
     */
    public $maxsize;
    /** @var null|float Maximum width in pixels to draw the line work. */
    public $maxwidth;
    /**
     * @var float Maximum width in pixels to draw the line work.
     * @version 5.4
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /**
     * @var null|float Minimum size in pixels to draw a symbol.
     * @deprecated 8.0
     */
    public $minsize;
    /** @var null|float Minimum width in pixels to draw the line work. */
    public $minwidth;
    /** @var null|int[] Geometry offset values in layer SIZEUNITS. */
    public $offset;
    /** @var null|int|string Opacity to draw the current style. */
    public $opacity;
    /** @var null|int[]|string Color to use for outlining polygons and certain marker symbols. */
    public $outlinecolor;
    /**
     * @var null|float|string Width in pixels for the outline.
     * @version 5.4
     */
    public $outlinewidth;
    /**
     * @var null|array<array<float>> Used to define a dash pattern for line work (lines, polygon outlines, hatch lines, …).
     * @version 6.0
     */
    public $pattern;
    /**
     * @var null|float[]|string[] Offset given in polar coordinates.
     * @version 6.2
     */
    public $polaroffset;
    /** @var null|string Specifies the attribute that will be used to map colors between the high and low ends of the COLORRANGE entry. */
    public $rangeitem;
    /** @var null|float|string Height, in layer SIZEUNITS, of the symbol/pattern to be used. */
    public $size;
    /** @var null|int|string The symbol to use for rendering the features. */
    public $symbol;
    /** @var null|float|string WIDTH refers to the thickness of line work drawn, in layer SIZEUNITS. */
    public $width;
}
