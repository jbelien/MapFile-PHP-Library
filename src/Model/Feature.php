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
 * MapFile Generator - Feature (FEATURE) Class.
 * [MapFile FEATURE clause](https://mapserver.org/mapfile/feature.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/feature.html
 */
class Feature
{
    /** @var array A set of xy pairs. */
    public $points = [];
    /** @var string Semicolon separated list of the feature attributes. */
    public $items;
    /** @var string String to use for labeling this feature. */
    public $text;
    /** @var string[] A geometry expressed in OpenGIS Well Known Text geometry format. */
    public $wkt = [];
}
