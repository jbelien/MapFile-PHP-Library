<?php
/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 * PHP Version 5.3+
 * @link https://github.com/jbelien/MapFile-Generator
 * @author Jonathan Beliën <jbe@geo6.be>
 * @copyright 2015 Jonathan Beliën
 * @license GNU General Public License, version 2
 * @note This project is still in development. Please use with caution !
 */
namespace MapFile;

/**
 * MapFile Generator - Map (MAP) Class.
 * [MapFile MAP clause](http://mapserver.org/mapfile/map.html).
 * @package MapFile
 * @author Jonathan Beliën <jbe@geo6.be>
 * @link http://mapserver.org/mapfile/map.html
 * @uses \MapFile\Legend
 * @uses \MapFile\Scalebar
 */
class Map {
  const STATUS_ON = 1;
  const STATUS_OFF = 0;

  const UNITS_INCHES = 0;
  const UNITS_FEET = 1;
  const UNITS_MILES = 2;
  const UNITS_METERS = 3;
  const UNITS_KILOMETERS = 4;
  const UNITS_DD = 5;
  const UNITS_PIXELS = 6;
  const UNITS_NAUTICALMILES = 8;

  /** @var string Path to fontset file. */
  private $fontsetfilename;
  /** @var string Path to symbolset file. */
  private $symbolsetfilename;
  /** @var string[] List of metadata's. */
  private $metadata = array();

  /** @var \MapFile\Layer[] List of layers. */
  private $_layers = array();

  /** @var float[] Spatial extent.*/
  public $extent = array(-1, -1, -1, -1);
  /** @var integer Size Y (height) in pixels of the output image. */
  public $height = 500;
  /**
  * @var integer[] Map background color (RGB Format).
  * @note Index `0` = Red [0-255], Index `1` = Green [0-255], Index `2` = Blue [0-255]
  */
  private $imagecolor;
  /** @var string MapFile name. */
  public $name = 'MYMAP';
  /**
  * @var string MapFile EPSG Projection.
  * @link http://epsg.io/
  * @link http://spatialreference.org/ref/epsg/
  */
  public $projection;
  /**
  * @var integer MapFile Status (Is the map active ?).
  * @note Use :
  * * self::STATUS_ON
  * * self::STATUS_OFF
  */
  public $status = self::STATUS_ON;
  /**
  * @var integer Units of the map coordinates.
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
  public $units = self::UNITS_METERS;
  /** @var integer Size X (width) in pixels of the output image. */
  public $width = 500;

  /**
  * @var \MapFile\Legend Map Legend object.
  */
  public $legend;
  /**
  * @var \MapFile\Scalebar Map Scalebar object.
  */
  public $scalebar;

  /**
  * Constructor.
  * @param string $mapfile Path to a valid .map MapFile.
  */
  public function __construct($mapfile = NULL) {
    if (!is_null($mapfile) && file_exists($mapfile)) $this->read($mapfile);

    if (is_null($this->legend)) $this->legend = new Legend();
    if (is_null($this->scalebar)) $this->scalebar = new Scalebar();
  }

  /**
  * Set the `extent` property.
  * @param float $minx
  * @param float $miny
  * @param float $maxx
  * @param float $maxy
  */
  public function setExtent($minx, $miny, $maxx, $maxy) {
    $this->extent = array($minx, $miny, $maxx, $maxy);
  }
  /**
  * Set the `fontsetfilename` property.
  * @param string $filename Path to a valid fontset file.
  * @throws \MapFile\Exception if filename does not exists.
  */
  public function setFontSet($filename) {
    if (file_exists($filename)) $this->fontsetfilename = $filename; else throw new Exception('FontSet file does not exists.');
  }
  /**
  * Set a `metadata` property.
  * @param string $key
  * @param string $value
  */
  public function setMetadata($key, $value) {
    $this->metadata[$key] = $value;
  }
  /**
  * Set `height` and `width` properties.
  * @param integer $width Width in pixels of the output image.
  * @param integer $height Height in pixels of the output image.
  */
  public function setSize($width, $height) {
    $this->width = intval($width);
    $this->height = intval($height);
  }
  /**
  * Set the `symbolsetfilename` property.
  * @param string $filename Path to a valid symbolset file.
  * @throws \MapFile\Exception if filename does not exists.
  */
  public function setSymbolSet($filename) {
    if (file_exists($filename)) $this->symbolsetfilename = $filename; else throw new Exception('SymbolSet file does not exists.');
  }
  /**
  * Set the `imagecolor` property.
  * @param integer $r Red component [0-255].
  * @param integer $g Green component [0-255].
  * @param integer $b Blue component [0-255].
  * @throws \MapFile\Exception if any component is lower < 0 or > 255
  */
  public function setImageColor($r,$g,$b) {
    if ($r >= 0 && $r <= 255 && $g >= 0 && $g <= 255 && $b >= 0 && $b <= 255)
      $this->imagecolor = array($r,$g,$b);
    else
      throw new Exception('Invalid STYLE COLOR('.$r.' '.$g.' '.$b.').');
  }

  /**
  * Return the list of the layers.
  * @return \MapFile\Layer[]
  */
  public function getLayers() {
    return $this->_layers;
  }
  /**
  * Return the layer matching the index sent as parameter.
  * @param integer $i Layer Index.
  * @return \MapFile\Layer|false false if the index is not found.
  */
  public function getLayer($i) {
    return (isset($this->_layers[$i]) ? $this->_layers[$i] : FALSE);
  }
  /**
  * Return the metadata matching the key sent as parameter.
  * @param string $key Metadata Key.
  * @return string|false false if the key is not found
  */
  public function getMetadata($key) {
    return (isset($this->metadata[$key]) ? $this->metadata[$key] : FALSE);
  }

  /**
  * Remove the metadata matching the key sent as parameter.
  * @param string $key Metadata Key.
  */
  public function removeMetadata($key) {
    if (isset($this->metadata[$key])) unset($this->metadata[$key]);
  }

  /**
  * Add a new \MapFile\Layer to the MapFile.
  * @param \MapFile\Layer $layer New Layer.
  * @return \MapFile\Layer New layer.
  */
  public function addLayer($layer = NULL) {
    if (is_null($layer)) $layer = new Layer();
    $count = array_push($this->_layers, $layer);
    return $this->_layers[$count-1];
  }

  /**
  * Remove the \MapFile\Layer matching the index sent as parameter.
  * @param integer $i Index.
  */
  public function removeLayer($i) {
    if (isset($this->_layers[$i])) { unset($this->_layers[$i]); $this->_layers = array_values($this->_layers); }
  }
  /**
  * Move the \MapFile\Layer matching the index sent as parameter up.
  * @param integer $i Index.
  */
  public function moveLayerUp($i) {
    if (isset($this->_layers[$i]) && $i > 0) {
      $tmp = $this->_layers[$i-1];
      $this->_layers[$i-1] = $this->_layers[$i];
      $this->_layers[$i] = $tmp;
    }
  }
  /**
  * Move the \MapFile\Layer matching the index sent as parameter down.
  * @param integer $i Index.
  */
  public function moveLayerDown($i) {
    if (isset($this->_layers[$i]) && $i < (count($this->_layers)-1)) {
      $tmp = $this->_layers[$i+1];
      $this->_layers[$i+1] = $this->_layers[$i];
      $this->_layers[$i] = $tmp;
    }
  }

  /**
  * Write the \MapFile\Map object to a MapFile.
  * @param string $filename Path to the new MapFile.
  * @uses \MapFile\Layer::write()
  * @uses \MapFile\Legend::write()
  * @uses \MapFile\Scalebar::write()
  */
  public function save($filename) {
    $f = fopen($filename, 'w');
    fwrite($f, 'MAP'.PHP_EOL);

    fwrite($f, '  STATUS '.self::convertStatus($this->status).PHP_EOL);
    fwrite($f, '  NAME "'.$this->name.'"'.PHP_EOL);
    if (!empty($this->extent)) fwrite($f, '  EXTENT '.implode(' ',$this->extent).PHP_EOL);
    if (!empty($this->imagecolor) && count($this->imagecolor) == 3 && array_sum($this->imagecolor) >= 0) fwrite($f, '  IMAGECOLOR '.implode(' ',$this->imagecolor).PHP_EOL);
    if (!empty($this->fontsetfilename)) fwrite($f, '  FONTSET "'.$this->fontsetfilename.'"'.PHP_EOL);
    if (!empty($this->symbolsetfilename)) fwrite($f, '  SYMBOLSET "'.$this->symbolsetfilename.'"'.PHP_EOL);
    if (!empty($this->width) && !empty($this->height)) fwrite($f, '  SIZE '.$this->width.' '.$this->height.PHP_EOL);
    if (!is_null($this->units)) fwrite($f, '  UNITS '.self::convertUnits($this->units).PHP_EOL);

    if (!empty($this->projection)) {
      fwrite($f, PHP_EOL);
      fwrite($f, '  PROJECTION'.PHP_EOL);
      fwrite($f, '    "init='.strtolower($this->projection).'"'.PHP_EOL);
      fwrite($f, '  END # PROJECTION'.PHP_EOL);
    }

    fwrite($f, PHP_EOL);
    fwrite($f, '  WEB'.PHP_EOL);
    if (!empty($this->metadata)) {
      fwrite($f, '    METADATA'.PHP_EOL);
      foreach ($this->metadata as $k => $v) fwrite($f, '      "'.$k.'" "'.$v.'"'.PHP_EOL);
      fwrite($f, '    END # METADATA'.PHP_EOL);
    }
    fwrite($f, '  END # WEB'.PHP_EOL);

    fwrite($f, PHP_EOL);
    fwrite($f, $this->legend->write());

    fwrite($f, PHP_EOL);
    fwrite($f, $this->scalebar->write());

    foreach ($this->_layers as $layer) {
      fwrite($f, PHP_EOL);
      fwrite($f, $layer->write());
    }

    fwrite($f, 'END # MAP'.PHP_EOL);
    fclose($f);
  }

  /**
  * Read a valid MapFile.
  * @param string $mapfile Path to the MapFile to read.
  * @uses \MapFile\Layer::read()
  * @uses \MapFile\Legend::read()
  * @uses \MapFile\Scalebar::read()
  */
  private function read($mapfile) {
    $map = FALSE; $reading = NULL;

    $h = fopen($mapfile, 'r');
    while (($_sz = fgets($h, 1024)) !== false) {
      $sz = trim($_sz);

      if (preg_match('/^MAP$/i', $sz)) $map = TRUE;
      else if ($map && is_null($reading) && preg_match('/^END( # MAP)?$/i', $sz)) $map = FALSE;

      else if ($map && is_null($reading) && preg_match('/^OUTPUTFORMAT$/i', $sz)) $reading = 'OUTPUTFORMAT';
      else if ($map && $reading == 'OUTPUTFORMAT' && preg_match('/^END( # OUTPUTFORMAT)?$/i', $sz)) $reading = NULL;
      else if ($map && $reading == 'OUTPUTFORMAT') continue;

      else if ($map && is_null($reading) && preg_match('/^QUERYMAP$/i', $sz)) $reading = 'QUERYMAP';
      else if ($map && $reading == 'QUERYMAP' && preg_match('/^END( # QUERYMAP)?$/i', $sz)) $reading = NULL;
      else if ($map && $reading == 'QUERYMAP') continue;

      else if ($map && is_null($reading) && preg_match('/^PROJECTION$/i', $sz)) $reading = 'PROJECTION';
      else if ($map && $reading == 'PROJECTION' && preg_match('/^END( # PROJECTION)?$/i', $sz)) $reading = NULL;
      else if ($map && $reading == 'PROJECTION' && preg_match('/^"init=(.+)"$/i', $sz, $matches)) $this->projection = $matches[1];

      else if ($map && is_null($reading) && preg_match('/^LEGEND$/i', $sz)) { $reading = 'LEGEND'; $legend[] = $sz; }
      else if ($map && $reading == 'LEGEND' && preg_match('/^LABEL$/i', $sz)) { $legend[] = $sz; $reading = 'LEGEND_LABEL'; }
      else if ($map && $reading == 'LEGEND' && preg_match('/^END( # LEGEND)?$/i', $sz)) { $legend[] = $sz; $this->legend = new Legend($legend); $reading = NULL; unset($legend); }
      else if ($map && $reading == 'LEGEND') { $legend[] = $sz; }
      else if ($map && $reading == 'LEGEND_LABEL' && preg_match('/^END( # LABEL)?$/i', $sz)) { $legend[] = $sz; $reading = 'LEGEND'; }
      else if ($map && $reading == 'LEGEND_LABEL') { $legend[] = $sz; }

      else if ($map && is_null($reading) && preg_match('/^SCALEBAR$/i', $sz)) { $reading = 'SCALEBAR'; $scalebar[] = $sz; }
      else if ($map && $reading == 'SCALEBAR' && preg_match('/^LABEL$/i', $sz)) { $scalebar[] = $sz; $reading = 'SCALEBAR_LABEL'; }
      else if ($map && $reading == 'SCALEBAR' && preg_match('/^END( # SCALEBAR)?$/i', $sz)) { $scalebar[] = $sz; $this->scalebar = new Scalebar($scalebar); $reading = NULL; unset($scalebar); }
      else if ($map && $reading == 'SCALEBAR') { $scalebar[] = $sz; }
      else if ($map && $reading == 'SCALEBAR_LABEL' && preg_match('/^END( # LABEL)?$/i', $sz)) { $scalebar[] = $sz; $reading = 'SCALEBAR'; }
      else if ($map && $reading == 'SCALEBAR_LABEL') { $scalebar[] = $sz; }

      else if ($map && is_null($reading) && preg_match('/^LAYER$/i', $sz)) { $reading = 'LAYER'; $layer[] = $sz; }
      else if ($map && $reading == 'LAYER' && preg_match('/^PROJECTION$/i', $sz)) { $layer[] = $sz; $reading = 'LAYER_PROJECTION'; }
      else if ($map && $reading == 'LAYER' && preg_match('/^CLASS$/i', $sz)) { $layer[] = $sz; $reading = 'LAYER_CLASS'; }
      else if ($map && $reading == 'LAYER' && preg_match('/^METADATA$/i', $sz)) { $layer[] = $sz; $reading = 'LAYER_METADATA'; }
      else if ($map && $reading == 'LAYER' && preg_match('/^VALIDATION$/i', $sz)) { $layer[] = $sz; $reading = 'LAYER_VALIDATION'; }
      else if ($map && $reading == 'LAYER' && preg_match('/^END( # LAYER)?$/i', $sz)) { $layer[] = $sz; $this->addLayer(new Layer($layer)); $reading = NULL; unset($layer); }
      else if ($map && $reading == 'LAYER') { $layer[] = $sz; }
      else if ($map && $reading == 'LAYER_PROJECTION' && preg_match('/^END( # PROJECTION)?$/i', $sz)) { $layer[] = $sz; $reading = 'LAYER'; }
      else if ($map && $reading == 'LAYER_PROJECTION') { $layer[] = $sz; }
      else if ($map && $reading == 'LAYER_CLASS' && preg_match('/^END( # CLASS)?$/i', $sz)) { $layer[] = $sz; $reading = 'LAYER'; }
      else if ($map && $reading == 'LAYER_CLASS') { $layer[] = $sz; }
      else if ($map && $reading == 'LAYER_METADATA' && preg_match('/^END( # METADATA)?$/i', $sz)) { $layer[] = $sz; $reading = 'LAYER'; }
      else if ($map && $reading == 'LAYER_METADATA') { $layer[] = $sz; }
      else if ($map && $reading == 'LAYER_VALIDATION' && preg_match('/^END( # VALIDATION)?$/i', $sz)) { $layer[] = $sz; $reading = 'LAYER'; }
      else if ($map && $reading == 'LAYER_VALIDATION') { $layer[] = $sz; }

      else if ($map && is_null($reading) && preg_match('/^WEB$/i', $sz)) { $reading = 'WEB'; }
      else if ($map && $reading == 'WEB' && preg_match('/^METADATA$/i', $sz)) { $reading = 'WEB_METADATA'; }
      else if ($map && $reading == 'WEB' && preg_match('/^END( # WEB)?$/i', $sz)) { $reading = NULL; }
      else if ($map && $reading == 'WEB_METADATA' && preg_match('/^END( # METADATA)?$/i', $sz)) { $reading = NULL; }
      else if ($map && $reading == 'WEB_METADATA' && preg_match('/^"(.+)"\s"(.+)"$/i', $sz, $matches)) { $this->metadata[$matches[1]] = $matches[2]; }

      else if ($map && is_null($reading) && preg_match('/^NAME "(.+)"$/i', $sz, $matches)) $this->name = $matches[1];
      else if ($map && is_null($reading) && preg_match('/^STATUS (.+)$/i', $sz, $matches)) $this->status = self::convertStatus(strtoupper($matches[1]));
      else if ($map && is_null($reading) && preg_match('/^EXTENT (-?[0-9\.]+) (-?[0-9\.]+) (-?[0-9\.]+) (-?[0-9\.]+)$/i', $sz, $matches)) $this->extent = array($matches[1], $matches[2], $matches[3], $matches[4]);
      else if ($map && is_null($reading) && preg_match('/^FONTSET "(.+)"$/i', $sz, $matches)) $this->fontsetfilename = $matches[1];
      else if ($map && is_null($reading) && preg_match('/^SYMBOLSET "(.+)"$/i', $sz, $matches)) $this->symbolsetfilename = $matches[1];
      else if ($map && is_null($reading) && preg_match('/^SIZE ([0-9]+) ([0-9]+)$/i', $sz, $matches)) $this->size = array($matches[1], $matches[2]);

      else if ($map && is_null($reading) && preg_match('/^UNITS (.+)$/i', $sz, $matches)) $this->units = self::convertUnits(strtoupper($matches[1]));
    }
    fclose($h);
  }

  /**
  * Convert `status` property to the text value or to the constant matching the text value.
  * @param string|integer $s
  * @return integer|string
  */
  private static function convertStatus($s = NULL) {
    $statuses = array(
      self::STATUS_ON  => 'ON',
      self::STATUS_OFF => 'OFF'
    );

    if (is_numeric($s)) return (isset($statuses[$s]) ? $statuses[$s] : FALSE);
    else return array_search($s, $statuses);
  }
  /**
  * Convert `units` property to the text value or to the constant matching the text value.
  * @param string|integer $u
  * @return integer|string
  */
  private static function convertUnits($u = NULL) {
    $units = array(
      self::UNITS_INCHES        => 'INCHES',
      self::UNITS_FEET          => 'FEET',
      self::UNITS_MILES         => 'MILES',
      self::UNITS_METERS        => 'METERS',
      self::UNITS_KILOMETERS    => 'KILOMETERS',
      self::UNITS_DD            => 'DD',
      self::UNITS_PIXELS        => 'PIXELS',
      self::UNITS_NAUTICALMILES => 'NAUTICALMILES'
    );

    if (is_numeric($u)) return (isset($units[$u]) ? $units[$u] : FALSE);
    else return array_search($u, $units);
  }
}