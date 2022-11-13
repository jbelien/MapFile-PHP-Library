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
class Map extends MapFileObject
{
    /** @var null|float Angle, given in degrees, to rotate the map. */
    public $angle;
    /** @var string[] This can be used to specify several values at run-time, for both MapServer and GDAL/OGR libraries. */
    public $config = [];
    /**
     * @var null|string This defines a regular expression to be applied to requests to change DATA parameters via URL requests (i.e. map.layer[layername]=DATA+…).
     * @deprecated 8.0 See VALIDATION instead.
     */
    public $datapattern;
    /** @var null|int Enables debugging of a layer in the current map. */
    public $debug;
    /**
     * @var null|int Sets the reference resolution (pixels per inch) used for symbology.
     * @version 5.6
     */
    public $defresolution;
    /** @var null|float[] Spatial extent. */
    public $extent;
    /** @var null|string Filename of fontset file to use. */
    public $fontset;
    /** @var null|int[]|string Map background color (RGB Format). */
    public $imagecolor;
    /** @var null|string Output format (raster or vector) to generate. */
    public $imagetype;
    /** @var string[] */
    public $include = [];
    /** @var ArrayCollection<int,Layer> */
    public $layer;
    /** @var null|Legend */
    public $legend;
    /** @var null|int Sets the maximum size of the map image. */
    public $maxsize;
    /** @var null|string MapFile name. */
    public $name;
    /** @var ArrayCollection<int,OutputFormat> */
    public $outputformat;
    /**
     * @var null|string MapFile EPSG Projection.
     *
     * @link http://epsg.io/
     * @link http://spatialreference.org/ref/epsg/
     */
    public $projection;
    /** @var null|QueryMap */
    public $querymap;
    /** @var null|Reference */
    public $reference;
    /** @var null|int Sets the pixels per inch for output. */
    public $resolution;
    /** @var null|Scalebar */
    public $scalebar;
    /** @var null|float Computed scale of the map. */
    public $scaledenom;
    /** @var null|string Path to the directory holding the shapefiles or tiles. */
    public $shapepath;
    /** @var null|int[] Size in pixels of the output image. */
    public $size;
    /** @var null|string MapFile Status (Is the map active ?). */
    public $status;
    /** @var ArrayCollection<int,Symbol> */
    public $symbol;
    /** @var null|string Filename of the symbolset to use. */
    public $symbolset;
    /**
     * @var null|string This defines a regular expression to be applied to requests to change the TEMPLATE parameters via URL requests (i.e. map.layer[layername].template=…).
     * @deprecated 8.0 See VALIDATION instead.
     */
    public $templatepattern;
    /** @var null|string Units of the map coordinates. */
    public $units;
    /** @var null|Web */
    public $web;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->layer = new ArrayCollection();
        $this->symbol = new ArrayCollection();
        $this->outputformat = new ArrayCollection();
    }
}
