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
 * MapFile Generator - Map (MAP) Class.
 * [MapFile MAP clause](https://mapserver.org/mapfile/map.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/map.html
 */
class Map
{
    /** @var string[] List of metadata's. */
    private $metadata = [];

    /** @var float Angle, given in degrees, to rotate the map. */
    public $angle;
    /** @var int Enables debugging of a layer in the current map. */
    public $debug;
    /** @var int Sets the reference resolution (pixels per inch) used for symbology. */
    public $defresolution;
    /** @var float[] Spatial extent. */
    public $extent;
    /** @var string Filename of fontset file to use. */
    public $fontset;
    /** @var int[]|string Map background color (RGB Format). */
    public $imagecolor;
    /** @var \Doctrine\Common\Collections\ArrayCollection */
    public $layer;
    /** @var \MapFile\Model\Legend */
    public $legend;
    /** @var int Sets the maximum size of the map image. */
    public $maxsize;
    /** @var string MapFile name. */
    public $name;
    /** @var \MapFile\Model\OutputFormat */
    public $outputformat;
    /**
     * @var string MapFile EPSG Projection.
     *
     * @link http://epsg.io/
     * @link http://spatialreference.org/ref/epsg/
     */
    public $projection;
    /** @var \MapFile\Model\QueryMap */
    public $querymap;
    /** @var \MapFile\Model\Reference */
    public $reference;
    /** @var int Sets the pixels per inch for output. */
    public $resolution;
    /** @var \MapFile\Model\Scalebar */
    public $scalebar;
    /** @var float Computed scale of the map. */
    public $scaledenom;
    /** @var string Path to the directory holding the shapefiles or tiles. */
    public $shapepath;
    /** @var int[] Size in pixels of the output image. */
    public $size;
    /** @var string MapFile Status (Is the map active ?). */
    public $status;
    /** @var \Doctrine\Common\Collections\ArrayCollection */
    public $symbol;
    /** @var string Filename of the symbolset to use. */
    public $symbolset;
    /** @var string Units of the map coordinates. */
    public $units;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->layer = new ArrayCollection();
        $this->symbol = new ArrayCollection();

        $this->legend = new Legend();
        $this->outputformat = new OutputFormat();
        $this->querymap = new QueryMap();
        $this->reference = new Reference();
        $this->scalebar = new Scalebar();
    }

    /**
     * Set a `metadata` property.
     *
     * @param string $key
     * @param string $value
     */
    public function setMetadata($key, $value)
    {
        $this->metadata[$key] = $value;
    }

    /**
     * Return the metadata matching the key sent as parameter.
     *
     * @param string $key Metadata Key.
     *
     * @return string|false false if the key is not found
     */
    public function getMetadata($key)
    {
        return isset($this->metadata[$key]) ? $this->metadata[$key] : false;
    }

    /**
     * Remove the metadata matching the key sent as parameter.
     *
     * @param string $key Metadata Key.
     */
    public function removeMetadata($key)
    {
        if (isset($this->metadata[$key])) {
            unset($this->metadata[$key]);
        }
    }
}
