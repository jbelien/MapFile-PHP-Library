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
 * MapFile Generator - Legend (LEGEND) Class.
 * [MapFile LEGEND clause](http://mapserver.org/mapfile/legend.html).
 *
 * @author Jonathan Beliën <jbe@geo6.be>
 *
 * @link http://mapserver.org/mapfile/legend.html
 */
class legend
{
    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    /**
     * @var int Legend Status (Is the legend active ?).
     * @note Use :
     * * self::STATUS_ON
     * * self::STATUS_OFF
     */
    public $status = self::STATUS_OFF;

    /**
     * @var \MapFile\Label Scalebar Label object.
     */
    public $label;

    /**
     * Constructor.
     *
     * @param string[] $legend Array containing MapFile LEGEND clause.
     *
     * @todo Must read a MapFile LEGEND clause without passing by an Array.
     */
    public function __construct($legend = null)
    {
        if (!is_null($legend)) {
            $this->read($legend);
        }

        if (is_null($this->label)) {
            $this->label = new Label();
        }
    }

    /**
     * Write a valid MapFile LEGEND clause.
     *
     * @return string
     *
     * @uses \MapFile\Label::write()
     */
    public function write()
    {
        $legend = '  LEGEND'.PHP_EOL;
        $legend .= '    STATUS '.self::convertStatus($this->status).PHP_EOL;
        $legend .= $this->label->write(2);
        $legend .= '  END # LEGEND'.PHP_EOL;

        return $legend;
    }

    /**
     * Read a valid MapFile LEGEND clause (as array).
     *
     * @param string[] $array MapFile LEGEND clause splitted in an array.
     *
     * @uses \MapFile\Label::read()
     *
     * @todo Must read a MapFile LEGEND clause without passing by an Array.
     */
    private function read($array)
    {
        $legend = false;
        $reading = null;

        foreach ($array as $_sz) {
            $sz = trim($_sz);

            if (preg_match('/^LEGEND$/i', $sz)) {
                $legend = true;
            } elseif ($legend && is_null($reading) && preg_match('/^END( # LEGEND)?$/i', $sz)) {
                $legend = false;
            } elseif ($legend && is_null($reading) && preg_match('/^LABEL$/i', $sz)) {
                $reading = 'LABEL';
                $label[] = $sz;
            } elseif ($legend && $reading == 'LABEL' && preg_match('/^END( # LABEL)?$/i', $sz)) {
                $label[] = $sz;
                $this->label = new Label($label);
                $reading = null;
                unset($label);
            } elseif ($legend && $reading == 'LABEL') {
                $label[] = $sz;
            } elseif ($legend && is_null($reading) && preg_match('/^STATUS (.+)$/i', $sz, $matches)) {
                $this->status = self::convertStatus(strtoupper($matches[1]));
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
}
