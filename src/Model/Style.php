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
class Style
{
    /** @var float|string Angle, given in degrees, to rotate the symbol (counter clockwise). */
    public $angle;
    /** @var bool Should TrueType fonts be antialiased. */
    public $antialias;
    /** @var int[]|string Color to use for drawing features. */
    public $color;
    /** @var int[]|string[] Defines two colors to correspond to the low and high ends of the DATARANGE values. */
    public $colorrange;
    /** @var int[]|float[] Defines two values, a low value and a high value, that Mapserver will map to the color range defined by the COLORRANGE entry. */
    public $datarange;
    /** @var float GAP specifies the distance between SYMBOLs (center to center) for decorated lines and polygon fills in layer SIZEUNITS. */
    public $gap;
    /**
     * @var string Used to indicate that the current feature will be transformed before the actual style is applied.
     *
     * @see https://mapserver.org/mapfile/geomtransform.html
     */
    public $geomtransform;
    /** @var float INITIALGAP is useful for styling dashed lines. */
    public $initialgap;
    /** @var string Sets the line cap type for lines. */
    public $linecap;
    /** @var string Sets the line join type for lines. */
    public $linejoin;
    /** @var int Sets the max length of the miter LINEJOIN type. */
    public $linejoinmaxsize;
    /**
     * @var float Minimum scale at which this STYLE is drawn.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /** @var float Maximum size in pixels to draw a symbol. */
    public $maxsize;
    /** @var float Maximum width in pixels to draw the line work. */
    public $maxwidth;
    /**
     * @var float Maximum width in pixels to draw the line work.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /** @var float Minimum size in pixels to draw a symbol. */
    public $minsize;
    /** @var float Minimum width in pixels to draw the line work. */
    public $minwidth;
    /** @var int[] Geometry offset values in layer SIZEUNITS. */
    public $offset;
    /** @var int|string Opacity to draw the current style. */
    public $opacity;
    /** @var int[]|string Color to use for outlining polygons and certain marker symbols. */
    public $outlinecolor;
    /** @var float|string Width in pixels for the outline. */
    public $outlinewidth;
    /** @var float[] Used to define a dash pattern for line work (lines, polygon outlines, hatch lines, …). */
    public $pattern;
    /** @var float[]|string[] Offset given in polar coordinates. */
    public $polaroffset;
    /** @var string Specifies the attribute that will be used to map colors between the high and low ends of the COLORRANGE entry. */
    public $rangeitem;
    /** @var float|string Height, in layer SIZEUNITS, of the symbol/pattern to be used. */
    public $size;
    /** @var int|string The symbol to use for rendering the features. */
    public $symbol;
    /** @var float|string WIDTH refers to the thickness of line work drawn, in layer SIZEUNITS. */
    public $width;
}
