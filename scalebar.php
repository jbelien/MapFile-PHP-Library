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
 * MapFile Generator - Scalebar (SCALEBAR) Class.
 * [MapFile SCALEBAR clause](http://mapserver.org/mapfile/scalebar.html).
 *
 * @author Jonathan Beliën <jbe@geo6.be>
 *
 * @link http://mapserver.org/mapfile/scalebar.html
 */
class scalebar
{
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

    /**
     * @var int[] Color (RGB Format).
     * @note Index `0` = Red [0-255], Index `1` = Green [0-255], Index `2` = Blue [0-255]
     */
    private $color = [0, 0, 0];
    /**
     * @var int[] Outline color (RGB Format).
     * @note Index `0` = Red [0-255], Index `1` = Green [0-255], Index `2` = Blue [0-255]
     */
    private $outlinecolor = [0, 0, 0];

    /** @var int $intervals Number of intervals to break the scalebar into. */
    public $intervals = 4;
    /**
     * @var int Scalebar Status (Is the scalebar active ?).
     * @note Use :
     * * self::STATUS_ON
     * * self::STATUS_OFF
     */
    public $status = self::STATUS_OFF;
    /**
     * @var int Units of the map coordinates.
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

    /**
     * @var \MapFile\Label Scalebar Label object.
     */
    public $label;

    /**
     * Constructor.
     *
     * @param string[] $scalebar Array containing MapFile SCALEBAR clause.
     *
     * @todo Must read a MapFile SCALEBAR clause without passing by an Array.
     */
    public function __construct($scalebar = null)
    {
        if (!is_null($scalebar)) {
            $this->read($scalebar);
        }

        if (is_null($this->label)) {
            $this->label = new Label();
        }
    }

    /**
     * Set the `color` property.
     *
     * @param int $r Red component [0-255].
     * @param int $g Green component [0-255].
     * @param int $b Blue component [0-255].
     *
     * @throws \MapFile\Exception if any component is lower < 0 or > 255
     */
    public function setColor($r, $g, $b)
    {
        if ($r >= 0 && $r <= 255 && $g >= 0 && $g <= 255 && $b >= 0 && $b <= 255) {
            $this->color = [$r, $g, $b];
        } else {
            throw new Exception('Invalid SCALEBAR COLOR('.$r.' '.$g.' '.$b.').');
        }
    }

    /**
     * Set the `outlinecolor` property.
     *
     * @param int $r Red component [0-255].
     * @param int $g Green component [0-255].
     * @param int $b Blue component [0-255].
     *
     * @throws \MapFile\Exception if any component is lower < 0 or > 255
     */
    public function setOutlineColor($r, $g, $b)
    {
        if ($r >= 0 && $r <= 255 && $g >= 0 && $g <= 255 && $b >= 0 && $b <= 255) {
            $this->outlinecolor = [$r, $g, $b];
        } else {
            throw new Exception('Invalid SCALEBAR OUTLINECOLOR('.$r.' '.$g.' '.$b.').');
        }
    }

    /**
     * Write a valid MapFile SCALEBAR clause.
     *
     * @return string
     *
     * @uses \MapFile\Label::write()
     */
    public function write()
    {
        $scalebar = '  SCALEBAR'.PHP_EOL;
        $scalebar .= '    STATUS '.self::convertStatus($this->status).PHP_EOL;
        if (!is_null($this->units)) {
            $scalebar .= '    UNITS '.self::convertUnits($this->units).PHP_EOL;
        }
        if (!empty($this->color) && array_sum($this->color) >= 0) {
            $scalebar .= '    COLOR '.implode(' ', $this->color).PHP_EOL;
        }
        if (!empty($this->outlinecolor) && array_sum($this->outlinecolor) >= 0) {
            $scalebar .= '    OUTLINECOLOR '.implode(' ', $this->outlinecolor).PHP_EOL;
        }
        if (!empty($this->intervals)) {
            $scalebar .= '    INTERVALS '.intval($this->intervals).PHP_EOL;
        }
        $scalebar .= $this->label->write(2);
        $scalebar .= '  END # SCALEBAR'.PHP_EOL;

        return $scalebar;
    }

    /**
     * Read a valid MapFile SCALEBAR clause (as array).
     *
     * @param string[] $array MapFile SCALEBAR clause splitted in an array.
     *
     * @uses \MapFile\Label::read()
     *
     * @todo Must read a MapFile SCALEBAR clause without passing by an Array.
     */
    private function read($array)
    {
        $scalebar = false;
        $reading = null;

        foreach ($array as $_sz) {
            $sz = trim($_sz);

            if (preg_match('/^SCALEBAR$/i', $sz)) {
                $scalebar = true;
            } elseif ($scalebar && is_null($reading) && preg_match('/^END( # SCALEBAR)?$/i', $sz)) {
                $scalebar = false;
            } elseif ($scalebar && is_null($reading) && preg_match('/^LABEL$/i', $sz)) {
                $reading = 'LABEL';
                $label[] = $sz;
            } elseif ($scalebar && $reading == 'LABEL' && preg_match('/^END( # LABEL)?$/i', $sz)) {
                $label[] = $sz;
                $this->label = new Label($label);
                $reading = null;
                unset($label);
            } elseif ($scalebar && $reading == 'LABEL') {
                $label[] = $sz;
            } elseif ($scalebar && is_null($reading) && preg_match('/^STATUS (.+)$/i', $sz, $matches)) {
                $this->status = self::convertStatus(strtoupper($matches[1]));
            } elseif ($scalebar && is_null($reading) && preg_match('/^INTERVALS ([0-9]+)$/i', $sz, $matches)) {
                $this->intervals = $matches[1];
            } elseif ($scalebar && is_null($reading) && preg_match('/^COLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $sz, $matches)) {
                $this->color = [$matches[1], $matches[2], $matches[3]];
            } elseif ($scalebar && is_null($reading) && preg_match('/^OUTLINECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $sz, $matches)) {
                $this->outlinecolor = [$matches[1], $matches[2], $matches[3]];
            } elseif ($scalebar && is_null($reading) && preg_match('/^UNITS (.+)$/i', $sz, $matches)) {
                $this->units = self::convertUnits(strtoupper($matches[1]));
            }
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

        if (is_numeric($s)) {
            return isset($statuses[$s]) ? $statuses[$s] : false;
        } else {
            return array_search($s, $statuses);
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
