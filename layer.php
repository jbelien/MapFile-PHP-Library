<?php
/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 * PHP Version 5.3+.
 *
 * @link https://github.com/jbelien/MapFile-Generator
 *
 * @author Jonathan Beliën <jbe@geo6.be>
 * @copyright 2015 Jonathan Beliën
 * @license GNU General Public License, version 2
 * @note This project is still in development. Please use with caution !
 */

namespace MapFile;

/**
 * MapFile Generator - Layer (LAYER) Class.
 * [MapFile LAYER clause](http://mapserver.org/mapfile/layer.html).
 *
 * @author Jonathan Beliën <jbe@geo6.be>
 *
 * @link http://mapserver.org/mapfile/layer.html
 */
class layer
{
    const CONNECTIONTYPE_CONTOUR = 0;
    const CONNECTIONTYPE_LOCAL = 1;
    const CONNECTIONTYPE_OGR = 2;
    const CONNECTIONTYPE_ORACLESPATIAL = 3;
    const CONNECTIONTYPE_PLUGIN = 4;
    const CONNECTIONTYPE_POSTGIS = 5;
    const CONNECTIONTYPE_SDE = 6;
    const CONNECTIONTYPE_UNION = 7;
    const CONNECTIONTYPE_UVRASTER = 8;
    const CONNECTIONTYPE_WFS = 9;
    const CONNECTIONTYPE_WMS = 10;

    const STATUS_ON = 1;
    const STATUS_OFF = 0;
    const STATUS_DEFAULT = 2;

    const TYPE_POINT = 0;
    const TYPE_LINE = 1;
    const TYPE_POLYGON = 2;
    const TYPE_RASTER = 3;
    const TYPE_QUERY = 5;
    const TYPE_CIRCLE = 6;
    const TYPE_TILEINDEX = 7;
    const TYPE_CHART = 8;

    const UNITS_INCHES = 0;
    const UNITS_FEET = 1;
    const UNITS_MILES = 2;
    const UNITS_METERS = 3;
    const UNITS_KILOMETERS = 4;
    const UNITS_DD = 5;
    const UNITS_PIXELS = 6;
    const UNITS_NAUTICALMILES = 8;

    /** @var string[] List of metadata's. */
    private $metadata = [];

    /** @var \MapFile\LayerClass[] List of classes. */
    private $_classes = [];

    /** @var string Database connection string to retrieve remote data. */
    public $connection;
    /**
     * @var int Type of connection.
     * @note Use :
     * * self::CONNECTIONTYPE_CONTOUR
     * * self::CONNECTIONTYPE_LOCAL
     * * self::CONNECTIONTYPE_OGR
     * * self::CONNECTIONTYPE_ORACLESPATIAL
     * * self::CONNECTIONTYPE_PLUGIN
     * * self::CONNECTIONTYPE_POSTGIS
     * * self::CONNECTIONTYPE_SDE
     * * self::CONNECTIONTYPE_UNION
     * * self::CONNECTIONTYPE_UVRASTER
     * * self::CONNECTIONTYPE_WFS
     * * self::CONNECTIONTYPE_WMS
     */
    public $connectiontype = self::CONNECTIONTYPE_LOCAL;
    /** @var string Item name in attribute table to use for class lookups. */
    public $classitem;
    /** @var string Full filename of the spatial data to process. */
    public $data;
    /** @var string Data specific attribute filtering. */
    public $filter;
    /** @var string Item to use with simple FILTER expressions. */
    public $filteritem;
    /** @var string Name of a group that this layer belongs to. */
    public $group;
    /** @var string Item name in attribute table to use for labeling. */
    public $labelitem;
    /**
     * @var float Maximum scale denominator.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /**
     * @var float Minimum scale denominator.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /** @var string Short name for this layer. */
    public $name;
    /**
     * @var int Opacity.
     * @note 0 = transparent - 100 = opaque
     */
    public $opacity = 100;
    /**
     * @var string MapFile EPSG Projection.
     *
     * @link http://epsg.io/
     * @link http://spatialreference.org/ref/epsg/
     */
    public $projection;
    /**
     * @var int Layer Status (Is the layer active ?).
     * @note Use :
     * * self::STATUS_ON
     * * self::STATUS_OFF
     */
    public $status = self::STATUS_OFF;
    /** @var string Item that contains the location of an individual tile. */
    public $tileitem = 'location';
    /** @var float Sensitivity for point based queries (given in TOLERANCEUNITS). */
    public $tolerance;
    /**
     * @var int Units of the TOLERANCE value.
     * @note Use :
     * * self::UNITS_INCHES
     * * self::UNITS_FEET
     * * self::UNITS_MILES
     * * self::UNITS_METERS
     * * self::UNITS_KILOMETERS
     * * self::UNITS_DD
     * * self::UNITS_PIXELS
     * * self::UNITS_NAUTICALMILES
     */
    public $tolereanceunits = self::UNITS_PIXELS;
    /**
     * @var int Specifies how the data should be drawn.
     * @note Use :
     * * self::TYPE_POINT
     * * self::TYPE_LINE
     * * self::TYPE_POLYGON
     * * self::TYPE_RASTER
     * * self::TYPE_QUERY
     * * self::TYPE_CIRCLE
     * * self::TYPE_TILEINDEX
     * * self::TYPE_CHART
     */
    public $type = self::TYPE_POINT;
    /**
     * @var int Units of the layer.
     * @note Use :
     * * self::UNITS_INCHES
     * * self::UNITS_FEET
     * * self::UNITS_MILES
     * * self::UNITS_METERS
     * * self::UNITS_KILOMETERS
     * * self::UNITS_DD
     * * self::UNITS_PIXELS
     * * self::UNITS_NAUTICALMILES
     */
    public $units;
    /** @var string[] List of VALIDATION blocks. */
    public $validation = [];

    /**
     * Constructor.
     *
     * @param string[] $layer Array containing MapFile LAYER clause.
     *
     * @todo Must read a MapFile LAYER clause without passing by an Array.
     */
    public function __construct($layer = null)
    {
        if (!is_null($layer)) {
            $this->read($layer);
        }
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
     * Return the list of the classes.
     *
     * @return \MapFile\LayerClass[]
     */
    public function getClasses()
    {
        return $this->_classes;
    }

    /**
     * Return the class matching the index sent as parameter.
     *
     * @param int $i Class Index.
     *
     * @return \MapFile\LayerClass|false false if the index is not found.
     */
    public function getClass($i)
    {
        return isset($this->_classes[$i]) ? $this->_classes[$i] : false;
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

    /**
     * Add a new \MapFile\LayerClass to the Layer.
     *
     * @param \MapFile\LayerClass $class New Class.
     *
     * @return \MapFile\LayerClass New Class.
     */
    public function addClass($class = null)
    {
        if (is_null($class)) {
            $class = new LayerClass();
        }
        $count = array_push($this->_classes, $class);

        return $this->_classes[$count - 1];
    }

    /**
     * Remove the \MapFile\LayerClass matching the index sent as parameter.
     *
     * @param int $i Index.
     */
    public function removeClass($i)
    {
        if (isset($this->_classes[$i])) {
            unset($this->_classes[$i]);
            $this->_classes = array_values($this->_classes);
        }
    }

    /**
     * Move the \MapFile\LayerClass matching the index sent as parameter up.
     *
     * @param int $i Index.
     */
    public function moveClassUp($i)
    {
        if (isset($this->_classes[$i]) && $i > 0) {
            $tmp = $this->_classes[$i - 1];
            $this->_classes[$i - 1] = $this->_classes[$i];
            $this->_classes[$i] = $tmp;
        }
    }

    /**
     * Move the \MapFile\LayerClass matching the index sent as parameter down.
     *
     * @param int $i Index.
     */
    public function moveClassDown($i)
    {
        if (isset($this->_classes[$i]) && $i < (count($this->_classes) - 1)) {
            $tmp = $this->_classes[$i + 1];
            $this->_classes[$i + 1] = $this->_classes[$i];
            $this->_classes[$i] = $tmp;
        }
    }

    /**
     * Write a valid MapFile LAYER clause.
     *
     * @return string
     *
     * @uses \MapFile\LayerClass::write()
     */
    public function write()
    {
        $layer = '  LAYER'.PHP_EOL;
        $layer .= '    STATUS '.self::convertStatus($this->status).PHP_EOL;
        if (!empty($this->group)) {
            $layer .= '    GROUP "'.$this->group.'"'.PHP_EOL;
        }
        if (!empty($this->name)) {
            $layer .= '    NAME "'.$this->name.'"'.PHP_EOL;
        }
        $layer .= '    TYPE '.self::convertType($this->type).PHP_EOL;
        if (!empty($this->units)) {
            $layer .= '    UNITS '.self::convertUnits($this->units).PHP_EOL;
        }
        if (!empty($this->connectiontype) && $this->connectiontype != self::CONNECTIONTYPE_LOCAL && !empty($this->connection)) {
            $layer .= '    CONNECTIONTYPE '.self::convertConnectiontype($this->connectiontype).PHP_EOL;
            $layer .= '    CONNECTION "'.$this->connection.'"'.PHP_EOL;
        }
        if (!empty($this->data)) {
            $layer .= '    DATA "'.$this->data.'"'.PHP_EOL;
        }
        if (!empty($this->filteritem)) {
            $layer .= '    FILTERITEM "'.$this->filteritem.'"'.PHP_EOL;
        }
        if (!empty($this->filter) && preg_match('/^\(.+\)$/i', $this->filter)) {
            $layer .= '    FILTER '.$this->filter.PHP_EOL;
        } elseif (!empty($this->filter) && !preg_match('/^\(.+\)$/i', $this->filter)) {
            $layer .= '    FILTER "'.$this->filter.'"'.PHP_EOL;
        }
        if (!empty($this->projection)) {
            $layer .= '    PROJECTION'.PHP_EOL;
            $layer .= '      "init='.strtolower($this->projection).'"'.PHP_EOL;
            $layer .= '    END # PROJECTION'.PHP_EOL;
        }
        if (!empty($this->metadata)) {
            $layer .= '    METADATA'.PHP_EOL;
            foreach ($this->metadata as $k => $v) {
                $layer .= '      "'.$k.'" "'.$v.'"'.PHP_EOL;
            }
            $layer .= '    END # METADATA'.PHP_EOL;
        }
        if (!empty($this->validation)) {
            $layer .= '    VALIDATION'.PHP_EOL;
            foreach ($this->validation as $k => $v) {
                $layer .= '      "'.$k.'" "'.$v.'"'.PHP_EOL;
            }
            $layer .= '    END # VALIDATION'.PHP_EOL;
        }
        if (!is_null($this->minscaledenom)) {
            $layer .= '    MINSCALEDENOM '.floatval($this->minscaledenom).PHP_EOL;
        }
        if (!is_null($this->maxscaledenom)) {
            $layer .= '    MAXSCALEDENOM '.floatval($this->maxscaledenom).PHP_EOL;
        }
        if (!is_null($this->opacity) && $this->opacity < 100) {
            $layer .= '    OPACITY '.intval($this->opacity).PHP_EOL;
        }
        if (!empty($this->classitem)) {
            $layer .= '    CLASSITEM "'.$this->classitem.'"'.PHP_EOL;
        }
        if (!empty($this->labelitem)) {
            $layer .= '    LABELITEM "'.$this->labelitem.'"'.PHP_EOL;
        }
        foreach ($this->_classes as $class) {
            $layer .= $class->write();
        }
        $layer .= '  END # LAYER'.PHP_EOL;

        return $layer;
    }

    /**
     * Read a valid MapFile LAYER clause (as array).
     *
     * @param string[] $array MapFile LAYER clause splitted in an array.
     *
     * @uses \MapFile\LayerClass::read()
     *
     * @todo Must read a MapFile LAYER clause without passing by an Array.
     */
    private function read($array)
    {
        $layer = false;
        $reading = null;

        foreach ($array as $_sz) {
            $sz = trim($_sz);

            if (preg_match('/^LAYER$/i', $sz)) {
                $layer = true;
            } elseif ($layer && is_null($reading) && preg_match('/^END( # LAYER)?$/i', $sz)) {
                $layer = false;
            } elseif ($layer && is_null($reading) && preg_match('/^PROJECTION$/i', $sz)) {
                $reading = 'PROJECTION';
            } elseif ($layer && $reading == 'PROJECTION' && preg_match('/^END( # PROJECTION)?$/i', $sz)) {
                $reading = null;
            } elseif ($layer && $reading == 'PROJECTION' && preg_match('/^"init=(.+)"$/i', $sz, $matches)) {
                $this->projection = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^CLASS$/i', $sz)) {
                $reading = 'CLASS';
                $class[] = $sz;
            } elseif ($layer && $reading == 'CLASS' && preg_match('/^LABEL$/i', $sz)) {
                $class[] = $sz;
                $reading = 'CLASS_LABEL';
            } elseif ($layer && $reading == 'CLASS' && preg_match('/^STYLE$/i', $sz)) {
                $class[] = $sz;
                $reading = 'CLASS_STYLE';
            } elseif ($layer && $reading == 'CLASS' && preg_match('/^END( # CLASS)?$/i', $sz)) {
                $class[] = $sz;
                $this->addClass(new LayerClass($class));
                $reading = null;
                unset($class);
            } elseif ($layer && $reading == 'CLASS') {
                $class[] = $sz;
            } elseif ($layer && $reading == 'CLASS_LABEL' && preg_match('/^END( # LABEL)?$/i', $sz)) {
                $class[] = $sz;
                $reading = 'CLASS';
            } elseif ($layer && $reading == 'CLASS_LABEL') {
                $class[] = $sz;
            } elseif ($layer && $reading == 'CLASS_STYLE' && preg_match('/^END( # STYLE)?$/i', $sz)) {
                $class[] = $sz;
                $reading = 'CLASS';
            } elseif ($layer && $reading == 'CLASS_STYLE') {
                $class[] = $sz;
            } elseif ($layer && is_null($reading) && preg_match('/^METADATA$/i', $sz)) {
                $reading = 'METADATA';
            } elseif ($layer && $reading == 'METADATA' && preg_match('/^END( # METADATA)?$/i', $sz)) {
                $reading = null;
            } elseif ($layer && $reading == 'METADATA' && preg_match('/^"(.+)"\s"(.+)"$/i', $sz, $matches)) {
                $this->metadata[$matches[1]] = $matches[2];
            } elseif ($layer && is_null($reading) && preg_match('/^VALIDATION$/i', $sz)) {
                $reading = 'VALIDATION';
            } elseif ($layer && $reading == 'VALIDATION' && preg_match('/^END( # VALIDATION)?$/i', $sz)) {
                $reading = null;
            } elseif ($layer && $reading == 'VALIDATION' && preg_match('/^"(.+)"\s+"(.+)"$/i', $sz, $matches)) {
                $this->validation[$matches[1]] = $matches[2];
            } elseif ($layer && is_null($reading) && preg_match('/^STATUS (.+)$/i', $sz, $matches)) {
                $this->status = self::convertStatus(strtoupper($matches[1]));
            } elseif ($layer && is_null($reading) && preg_match('/^TYPE (.+)$/i', $sz, $matches)) {
                $this->type = self::convertType(strtoupper($matches[1]));
            } elseif ($layer && is_null($reading) && preg_match('/^NAME "(.+)"$/i', $sz, $matches)) {
                $this->name = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^CLASSITEM "(.+)"$/i', $sz, $matches)) {
                $this->classitem = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^CONNECTIONTYPE (.+)$/i', $sz, $matches)) {
                $this->connectiontype = self::convertConnectiontype(strtoupper($matches[1]));
            } elseif ($layer && is_null($reading) && preg_match('/^CONNECTION "(.+)"$/i', $sz, $matches)) {
                $this->connection = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^DATA "(.+)"$/i', $sz, $matches)) {
                $this->data = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^FILTER "(.+)"$/i', $sz, $matches)) {
                $this->filter = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^FILTERITEM "(.+)"$/i', $sz, $matches)) {
                $this->filteritem = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^GROUP "(.+)"$/i', $sz, $matches)) {
                $this->group = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^LABELITEM "(.+)"$/i', $sz, $matches)) {
                $this->labelitem = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^MAXSCALEDENOM ([0-9\.]+)$/i', $sz, $matches)) {
                $this->maxscaledenom = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^MINSCALEDENOM ([0-9\.]+)$/i', $sz, $matches)) {
                $this->minscaledenom = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^OPACITY ([0-9]+)$/i', $sz, $matches)) {
                $this->opacity = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^TILEITEM "(.+)"$/i', $sz, $matches)) {
                $this->tileitem = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^TOLERANCE ([0-9\.]+)$/i', $sz, $matches)) {
                $this->tolerance = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^TOLERANCEUNITS (.+)$/i', $sz, $matches)) {
                $this->toleranceunits = $matches[1];
            } elseif ($layer && is_null($reading) && preg_match('/^UNITS (.+)$/i', $sz, $matches)) {
                $this->units = self::convertUnits(strtoupper($matches[1]));
            }

            /* Multiline DATA */
            elseif ($layer && is_null($reading) && preg_match('/^DATA "(.+)$/i', $sz, $matches)) {
                $reading = 'DATA';
                $this->data = $matches[1];
            } elseif ($layer && $reading == 'DATA' && preg_match('/(.+)"$/i', $sz, $matches)) {
                $reading = null;
                $this->data .= ' '.$matches[1];
            } elseif ($layer && $reading == 'DATA' && preg_match('/(.+)$/i', $sz, $matches)) {
                $this->data .= ' '.$matches[1];
            }
        }
    }

    /**
     * Convert `connectiontype` property to the text value or to the constant matching the text value.
     *
     * @param string|int $c
     *
     * @return int|string
     */
    private static function convertConnectiontype($c = null)
    {
        $connectiontypes = [
      self::CONNECTIONTYPE_CONTOUR       => 'CONTOUR',
      self::CONNECTIONTYPE_LOCAL         => 'LOCAL',
      self::CONNECTIONTYPE_OGR           => 'OGR',
      self::CONNECTIONTYPE_ORACLESPATIAL => 'ORACLESPATIAL',
      self::CONNECTIONTYPE_PLUGIN        => 'PLUGIN',
      self::CONNECTIONTYPE_POSTGIS       => 'POSTGIS',
      self::CONNECTIONTYPE_SDE           => 'SDE',
      self::CONNECTIONTYPE_UNION         => 'UNION',
      self::CONNECTIONTYPE_UVRASTER      => 'UVRASTER',
      self::CONNECTIONTYPE_WFS           => 'WFS',
      self::CONNECTIONTYPE_WMS           => 'WMS',
    ];

        if (is_numeric($c)) {
            return isset($connectiontypes[$c]) ? $connectiontypes[$c] : false;
        } else {
            return array_search($c, $connectiontypes);
        }
    }

    /**
     * Convert `status` property to the text value or to the constant matching the text value.
     *
     * @param string|int $s
     *
     * @return int|string
     */
    private static function convertStatus($s = null)
    {
        $statuses = [
      self::STATUS_ON  => 'ON',
      self::STATUS_OFF => 'OFF',
    ];

        if (is_null($s)) {
            return $statuses[$this->status];
        } elseif (is_numeric($s)) {
            return isset($statuses[$s]) ? $statuses[$s] : false;
        } else {
            return array_search($s, $statuses);
        }
    }

    /**
     * Convert `type` property to the text value or to the constant matching the text value.
     *
     * @param string|int $t
     *
     * @return int|string
     */
    private static function convertType($t = null)
    {
        $types = [
      self::TYPE_POINT     => 'POINT',
      self::TYPE_LINE      => 'LINE',
      self::TYPE_POLYGON   => 'POLYGON',
      self::TYPE_RASTER    => 'RASTER',
      self::TYPE_QUERY     => 'QUERY',
      self::TYPE_CIRCLE    => 'CIRCLE',
      self::TYPE_TILEINDEX => 'TILEINDEX',
      self::TYPE_CHART     => 'CHART',
    ];

        if (is_numeric($t)) {
            return isset($types[$t]) ? $types[$t] : false;
        } else {
            return array_search($t, $types);
        }
    }

    /**
     * Convert `units` property to the text value or to the constant matching the text value.
     *
     * @param string|int $u
     *
     * @return int|string
     */
    private static function convertUnits($u = null)
    {
        $units = [
      self::UNITS_INCHES        => 'INCHES',
      self::UNITS_FEET          => 'FEET',
      self::UNITS_MILES         => 'MILES',
      self::UNITS_METERS        => 'METERS',
      self::UNITS_KILOMETERS    => 'KILOMETERS',
      self::UNITS_DD            => 'DD',
      self::UNITS_PIXELS        => 'PIXELS',
      self::UNITS_NAUTICALMILES => 'NAUTICALMILES',
    ];

        if (is_numeric($u)) {
            return isset($units[$u]) ? $units[$u] : false;
        } else {
            return array_search($u, $units);
        }
    }
}
