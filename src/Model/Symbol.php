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
 * MapFile Generator - Symbol (SYMBOL) Class.
 * [MapFile SYMBOL clause](https://mapserver.org/mapfile/symbol.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/symbol.html
 */
class Symbol
{
    /** @var float[] Used to specify the location (within the symbol) that is to be used as an anchorpoint when rotating the symbol and placing the symbol on a map. */
    public $anchorpoint;
    /** @var bool Should TrueType fonts be antialiased. */
    public $antialias;
    /** @var string Character used to reference a particular TrueType font character. */
    public $character;
    /** @var bool If true, the symbol will be filled with a user defined color. */
    public $filled;
    /** @var string Name of TrueType font to use as defined in the FONTSET. */
    public $font;
    /** @var string Image (GIF or PNG) to use as a marker or brush for type pixmap symbols. */
    public $image;
    /** @var string Alias for the symbol. */
    public $name;
    /** @var float[] Sequence of points that make up a symbol of TYPE vector or that define the x and y radius of a symbol of TYPE ellipse. */
    public $points;
    /** @var int Sets a transparent color for the input image for pixmap symbols, or determines whether all shade symbols should have a transparent background. */
    public $transparent;
    /** @var string */
    public $type;
}
