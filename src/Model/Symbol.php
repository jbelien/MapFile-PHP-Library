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
class Symbol extends MapFileObject
{
    /**
     * @var null|float[] Used to specify the location (within the symbol) that is to be used as an anchorpoint when rotating the symbol and placing the symbol on a map.
     *
     * @version 6.2
     */
    public $anchorpoint;
    /**
     * @var null|bool Should TrueType fonts be antialiased.
     *
     * @deprecated 7.0
     */
    public $antialias;
    /** @var null|string Character used to reference a particular TrueType font character. */
    public $character;
    /** @var null|bool If true, the symbol will be filled with a user defined color. */
    public $filled;
    /** @var null|string Name of TrueType font to use as defined in the FONTSET. */
    public $font;
    /** @var null|string Image (GIF or PNG) to use as a marker or brush for type pixmap symbols. */
    public $image;
    /** @var null|string Alias for the symbol. */
    public $name;
    /** @var null|array<array<float>> Sequence of points that make up a symbol of TYPE vector or that define the x and y radius of a symbol of TYPE ellipse. */
    public $points;
    /**
     * @var null|int Sets a transparent color for the input image for pixmap symbols, or determines whether all shade symbols should have a transparent background.
     *
     * @deprecated 7.0
     */
    public $transparent;
    /** @var null|string */
    public $type;
}
