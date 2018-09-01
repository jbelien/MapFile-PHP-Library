<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Model;

use SplObjectStorage;

/**
 * MapFile Generator - Layer (LAYER) Class.
 * [MapFile LAYER clause](https://mapserver.org/mapfile/layer.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/layer.html
 */
class Layer
{
    /** @var \SplObjectStorage */
    public $_classes;
    /** @var \SplObjectStorage */
    public $_features;

    /** @var string[] List of metadata's. */
    private $metadata = [];

    /** @var string Specify the class’s group that would be considered at rendering time. */
    public $classgroup;
    /** @var string Item name in attribute table to use for class lookups. */
    public $classitem;
    /** @var \MapFile\Model\Cluster */
    public $cluster;
    /** @var \SplObjectStorage */
    public $composite;
    /** @var string Database connection string to retrieve remote data. */
    public $connection;
    /** @var string Type of connection. */
    public $connectiontype;
    /** @var string Full filename of the spatial data to process. */
    public $data;
    /** @var int Enables debugging of a layer in the current map. */
    public $debug;
    /** @var string The encoding used for text in the layer data source. */
    public $encoding;
    /** @var float[] Spatial extent. */
    public $extent;
    /** @var string Data specific attribute filtering. */
    public $filter;
    /** @var string Item to use with simple FILTER expressions. */
    public $filteritem;
    /** @var string Template to use after a layer’s set of results have been sent. */
    public $footer;
    /** @var string Name of a group that this layer belongs to. */
    public $group;
    /** @var string Template to use before a layer’s set of results have been sent. */
    public $header;
    /** @var \SplObjectStorage */
    public $join;
    /** @var string Specifies whether labels should be drawn as the features for this layer are drawn, or whether they should be cached and drawn after all layers have been drawn. */
    public $labelcache;
    /** @var string Item name in attribute table to use for labeling. */
    public $labelitem;
    /**
     * @var float Minimum scale at which this LAYER is labeled.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $labelmaxscaledenom;
    /**
     * @var float Maximum scale at which this LAYER is labeled.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $labelminscaledenom;
    /** @var string Sets context for labeling this layer. */
    public $labelrequires;
    /** @var string The data from the current layer will only be rendered where it intersects features from the [layername] layer. */
    public $mask;
    /** @var int Specifies the number of features that should be drawn for this layer in the CURRENT window. */
    public $maxfeatures;
    /** @var float Maximum width, in the map’s geographic units, at which this LAYER is drawn. */
    public $maxgeowidth;
    /**
     * @var float Minimum scale denominator.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /** @var float Minimum width, in the map’s geographic units, at which this LAYER is drawn. */
    public $mingeowidth;
    /**
     * @var float Maximum scale denominator.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /** @var string Short name for this layer. */
    public $name;
    /** @var int[] Sets the color index to treat as transparent for raster layers. */
    public $offsite;
    /** @var int Opacity. */
    public $opacity;
    /** @var string Additional library to load by MapServer, for this layer. */
    public $plugin;
    /** @var bool Tells MapServer to render this layer after all labels in the cache have been drawn. */
    public $postlabelcache;
    /**
     * @var string MapFile EPSG Projection.
     *
     * @link http://epsg.io/
     * @link http://spatialreference.org/ref/epsg/
     */
    public $projection;
    /** @var string Sets context for displaying this layer. */
    public $requires;
    /** @var \MapFile\Model\ScaleToken */
    public $scaletoken;
    /** @var string Sets the unit of STYLE object SIZE values (default is pixels). */
    public $sizeunits;
    /** @var string Layer Status (Is the layer active ?). */
    public $status;
    /** @var string Styling based on attributes or generated with Javascript. */
    public $styleitem;
    /** @var float The scale at which symbols and/or text appear full size. */
    public $symbolscaledenom;
    /**
     * @var string Used as a global alternative to CLASS TEMPLATE.
     *
     * @see https://mapserver.org/mapfile/template.html#template
     */
    public $template;
    /**
     * @var string Name of the tileindex file or layer.
     *
     * @see https://mapserver.org/optimization/tileindex.html#tileindex
     */
    public $tileindex;
    /** @var string Item that contains the location of an individual tile. */
    public $tileitem;
    /** @var string Name of the attribute that contains the SRS of an individual tile. */
    public $tilesrs;
    /** @var float Sensitivity for point based queries (given in TOLERANCEUNITS). */
    public $tolerance;
    /** @var string Units of the TOLERANCE value. */
    public $tolereanceunits;
    /** @var bool|string Tells MapServer whether or not a particular layer needs to be transformed from some coordinate system to image coordinates. */
    public $transform;
    /** @var string Specifies how the data should be drawn. */
    public $type;
    /** @var string Units of the layer. */
    public $units;
    /** @var string A UTFGrid JSON template. */
    public $utfdata;
    /** @var string The attribute to use as the ID for the UTFGrid. */
    public $utfitem;
    /** @var string[] */
    public $validation;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->_classes = new SplObjectStorage();
        $this->_features = new SplObjectStorage();

        $this->composite = new SplObjectStorage();
        $this->join = new SplObjectStorage();

        $this->scaletoken = new ScaleToken();
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
