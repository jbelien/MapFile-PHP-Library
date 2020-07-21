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
 * MapFile Generator - Cluster (CLUSTER) Class.
 * [MapFile CLUSTER clause](https://mapserver.org/mapfile/cluster.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/cluster.html
 */
class Cluster
{
    /** @var float Specifies the distance of the search region (rectangle or ellipse) in pixel positions. */
    public $maxdistance;
    /** @var string Defines the search region around a feature in which the neighbouring features are negotiated. */
    public $region;
    /** @var float Defines a buffer region around the map extent in pixels. */
    public $buffer;
    /** @var string This expression evaluates to a string and only the features that have the same group value are negotiated. */
    public $group;
    /** @var string We can define the FILTER expression filter some of the features from the final output. */
    public $filter;
}
