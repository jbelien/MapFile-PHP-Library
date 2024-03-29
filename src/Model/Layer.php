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
 * MapFile Generator - Layer (LAYER) Class.
 * [MapFile LAYER clause](https://mapserver.org/mapfile/layer.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/layer.html
 */
class Layer extends MapFileObject
{
    /**
     * @var array<int|string,string> Bind variables in SQL statements.
     *
     * @version 6.0
     */
    public $bindvals = [];
    /** @var ArrayCollection<int,LayerClass> */
    public $class;
    /** @var null|string Specify the class’s group that would be considered at rendering time. */
    public $classgroup;
    /** @var null|string Item name in attribute table to use for class lookups. */
    public $classitem;
    /** @var null|Cluster */
    public $cluster;
    /** @var ArrayCollection<int,Composite> */
    public $composite;
    /** @var null|string Database connection string to retrieve remote data. */
    public $connection;
    /**
     * @var string[] This keyword allows to define connection options expressed as key / value pairs.
     *
     * @version 7.6
     */
    public $connectionoptions = [];
    /** @var null|string Type of connection. */
    public $connectiontype;
    /** @var null|string Full filename of the spatial data to process. */
    public $data;
    /** @var null|int Enables debugging of a layer in the current map. */
    public $debug;
    /**
     * @var null|string The encoding used for text in the layer data source.
     *
     * @version 7.0
     */
    public $encoding;
    /** @var null|float[] Spatial extent. */
    public $extent;
    /** @var ArrayCollection<int,Feature> */
    public $feature;
    /** @var null|string Data specific attribute filtering. */
    public $filter;
    /** @var null|string Item to use with simple FILTER expressions. */
    public $filteritem;
    /** @var null|string Template to use after a layer’s set of results have been sent. */
    public $footer;
    /**
     * @var null|string Used to indicate that the current feature will be transformed.
     *
     * @version 6.4
     *
     * @see https://mapserver.org/mapfile/geomtransform.html
     */
    public $geomtransform;
    /** @var null|Grid */
    public $grid;
    /** @var null|string Name of a group that this layer belongs to. */
    public $group;
    /** @var null|string Template to use before a layer’s set of results have been sent. */
    public $header;
    /** @var ArrayCollection<int,Join> */
    public $join;
    /** @var null|string Specifies whether labels should be drawn as the features for this layer are drawn, or whether they should be cached and drawn after all layers have been drawn. */
    public $labelcache;
    /** @var null|string Item name in attribute table to use for labeling. */
    public $labelitem;
    /**
     * @var null|float Minimum scale at which this LAYER is labeled.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $labelmaxscaledenom;
    /**
     * @var null|float Maximum scale at which this LAYER is labeled.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $labelminscaledenom;
    /** @var null|string Sets context for labeling this layer. */
    public $labelrequires;
    /** @var null|string The data from the current layer will only be rendered where it intersects features from the [layername] layer. */
    public $mask;
    /** @var null|int Specifies the number of features that should be drawn for this layer in the CURRENT window. */
    public $maxfeatures;
    /**
     * @var null|float Maximum width, in the map’s geographic units, at which this LAYER is drawn.
     *
     * @version 5.4
     */
    public $maxgeowidth;
    /**
     * @var null|float Minimum scale denominator.
     *
     * @version 5.0
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /** @var array<string,string> List of metadata's. */
    public $metadata = [];
    /** @var null|int Minimum feature size (in pixels) for shapes in the layer. */
    public $minfeaturesize;
    /**
     * @var null|float Minimum width, in the map’s geographic units, at which this LAYER is drawn.
     *
     * @version 5.4
     */
    public $mingeowidth;
    /**
     * @var null|float Maximum scale denominator.
     *
     * @version 7.6
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /** @var null|string Short name for this layer. */
    public $name;
    /** @var null|int[]|string Sets the color index to treat as transparent for raster layers. */
    public $offsite;
    /**
     * @var null|int Opacity.
     *
     * @deprecated 8.0 Use a COMPOSITE block instead.
     */
    public $opacity;
    /** @var null|string Additional library to load by MapServer, for this layer. */
    public $plugin;
    /** @var null|bool Tells MapServer to render this layer after all labels in the cache have been drawn. */
    public $postlabelcache;
    /** @var string[] Passes a processing directive to be used with this layer. */
    public $processing = [];
    /**
     * @var null|string MapFile EPSG Projection.
     *
     * @link http://epsg.io/
     * @link http://spatialreference.org/ref/epsg/
     */
    public $projection;
    /** @var null|string Sets context for displaying this layer. */
    public $requires;
    /**
     * @var null|ScaleToken
     *
     * @version 6.4
     */
    public $scaletoken;
    /** @var null|string Sets the unit of STYLE object SIZE values (default is pixels). */
    public $sizeunits;
    /** @var null|string Layer Status (Is the layer active ?). */
    public $status;
    /** @var null|string Styling based on attributes or generated with Javascript. */
    public $styleitem;
    /** @var null|float The scale at which symbols and/or text appear full size. */
    public $symbolscaledenom;
    /**
     * @var null|string Used as a global alternative to CLASS TEMPLATE.
     *
     * @see https://mapserver.org/mapfile/template.html#template
     */
    public $template;
    /**
     * @var null|string Name of the tileindex file or layer.
     *
     * @see https://mapserver.org/optimization/tileindex.html#tileindex
     */
    public $tileindex;
    /** @var null|string Item that contains the location of an individual tile. */
    public $tileitem;
    /** @var null|string Name of the attribute that contains the SRS of an individual tile. */
    public $tilesrs;
    /** @var null|float Sensitivity for point based queries (given in TOLERANCEUNITS). */
    public $tolerance;
    /** @var null|string Units of the TOLERANCE value. */
    public $toleranceunits;
    /** @var null|bool|string Tells MapServer whether or not a particular layer needs to be transformed from some coordinate system to image coordinates. */
    public $transform;
    /** @var null|string Specifies how the data should be drawn. */
    public $type;
    /** @var null|string Units of the layer. */
    public $units;
    /**
     * @var null|string A UTFGrid JSON template.
     *
     * @version 7.0
     */
    public $utfdata;
    /**
     * @var null|string The attribute to use as the ID for the UTFGrid.
     *
     * @version 7.0
     */
    public $utfitem;
    /** @var null|array<string,string> */
    public $validation;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->class = new ArrayCollection();
        $this->composite = new ArrayCollection();
        $this->feature = new ArrayCollection();
        $this->join = new ArrayCollection();
    }
}
