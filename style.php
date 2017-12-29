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
 * MapFile Generator - Style (STYLE) Class.
 * [MapFile STYLE clause](http://mapserver.org/mapfile/style.html).
 *
 * @author Jonathan Beliën <jbe@geo6.be>
 *
 * @link http://mapserver.org/mapfile/style.html
 */
class style
{
    /**
     * @var int[] Color (RGB Format).
     * @note Index `0` = Red [0-255], Index `1` = Green [0-255], Index `2` = Blue [0-255]
     */
    private $color;
    /**
     * @var int[] Outline color (RGB Format).
     * @note Index `0` = Red [0-255], Index `1` = Green [0-255], Index `2` = Blue [0-255]
     */
    private $outlinecolor;

    /** @var float Angle (in degrees). */
    public $angle;
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
    /**
     * @var int Opacity.
     * @note 0 = transparent - 100 = opaque
     */
    public $opacity;
    /** @var float Outline width (in pixles). */
    public $outlinewidth;
    /** @var float Height (in layer SIZEUNITS) or the symbol/pattern. */
    public $size;
    /** @var string Symbol name (must be defined in Symbol Set file). */
    public $symbolname;
    /** @var float Width (in layer SIZEUNITS). */
    public $width;
    /** @var float[] Pattern. */
    public $pattern = [];

    /**
     * Constructor.
     *
     * @param string[] $style Array containing MapFile STYLE clause.
     *
     * @todo Must read a MapFile STYLE clause without passing by an Array.
     */
    public function __construct($style = null)
    {
        if (!is_null($style)) {
            $this->read($style);
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
            throw new Exception('Invalid STYLE COLOR('.$r.' '.$g.' '.$b.').');
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
            throw new Exception('Invalid STYLE OUTLINECOLOR('.$r.' '.$g.' '.$b.').');
        }
    }

    /**
     * Get the `color` property.
     *
     * @return int[]
     */
    public function getColor()
    {
        return is_null($this->color) ? [] : ['r' => $this->color[0], 'g' => $this->color[1], 'b' => $this->color[2]];
    }

    /**
     * Get the `outlinecolor` property.
     *
     * @return int[]
     */
    public function getOutlineColor()
    {
        return is_null($this->outlinecolor) ? [] : ['r' => $this->outlinecolor[0], 'g' => $this->outlinecolor[1], 'b' => $this->outlinecolor[2]];
    }

    /**
     * Unset `color` property.
     */
    public function unsetColor()
    {
        $this->color = null;
    }

    /**
     * Unset `outlinecolor` property.
     */
    public function unsetOutlineColor()
    {
        $this->outlinecolor = null;
    }

    /**
     * Write a valid MapFile STYLE clause.
     *
     * @return string
     */
    public function write()
    {
        $style = '      STYLE'.PHP_EOL;
        if (!is_null($this->angle)) {
            $style .= '        ANGLE '.floatval($this->angle).PHP_EOL;
        }
        if (!empty($this->color) && count($this->color) == 3 && array_sum($this->color) >= 0) {
            $style .= '        COLOR '.implode(' ', $this->color).PHP_EOL;
        }
        if (!is_null($this->maxscaledenom)) {
            $style .= '        MAXSCALEDENOM '.floatval($this->maxscaledenom).PHP_EOL;
        }
        if (!is_null($this->minscaledenom)) {
            $style .= '        MINSCALEDENOM '.floatval($this->minscaledenom).PHP_EOL;
        }
        if (!is_null($this->opacity)) {
            $style .= '        OPACITY '.intval($this->opacity).PHP_EOL;
        }
        if (!empty($this->outlinecolor) && count($this->outlinecolor) == 3 && array_sum($this->outlinecolor) >= 0) {
            $style .= '        OUTLINECOLOR '.implode(' ', $this->outlinecolor).PHP_EOL;
        }
        if (!is_null($this->outlinewidth)) {
            $style .= '        OUTLINEWIDTH '.floatval($this->outlinewidth).PHP_EOL;
        }
        if (!is_null($this->size)) {
            $style .= '        SIZE '.floatval($this->size).PHP_EOL;
        }
        if (!is_null($this->width)) {
            $style .= '        WIDTH '.floatval($this->width).PHP_EOL;
        }
        if (!empty($this->symbolname)) {
            $style .= '        SYMBOL "'.$this->symbolname.'"'.PHP_EOL;
        }
        if (!empty($this->pattern)) {
            $style .= '        PATTERN'.PHP_EOL;
            $style .= '          '.implode(' ', $this->pattern).PHP_EOL;
            $style .= '        END # PATTERN'.PHP_EOL;
        }
        $style .= '      END # STYLE'.PHP_EOL;

        return $style;
    }

    /**
     * Read a valid MapFile STYLE clause (as array).
     *
     * @param string[] $array MapFile STYLE clause splitted in an array.
     *
     * @todo Must read a MapFile STYLE clause without passing by an Array.
     */
    private function read($array)
    {
        $style = false;
        $reading = null;

        foreach ($array as $_sz) {
            $sz = trim($_sz);

            if (preg_match('/^STYLE$/i', $sz)) {
                $style = true;
            } elseif ($style && is_null($reading) && preg_match('/^END( # STYLE)?$/i', $sz)) {
                $style = false;
            } elseif ($style && is_null($reading) && preg_match('/^PATTERN$/i', $sz)) {
                $reading = 'PATTERN';
            } elseif ($style && $reading == 'PATTERN' && preg_match('/^END( # PATTERN)?$/i', $sz)) {
                $reading = null;
            } elseif ($style && $reading == 'PATTERN' && preg_match('/^(.+)$/i', $sz, $matches)) {
                $this->pattern = array_merge($this->pattern, explode(' ', $matches[1]));
            } elseif ($style && is_null($reading) && preg_match('/^ANGLE ([0-9\.]+)$/i', $sz, $matches)) {
                $this->angle = $matches[1];
            } elseif ($style && is_null($reading) && preg_match('/^COLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $sz, $matches)) {
                $this->color = [$matches[1], $matches[2], $matches[3]];
            } elseif ($style && is_null($reading) && preg_match('/^MAXSCALEDENOM ([0-9\.]+)$/i', $sz, $matches)) {
                $this->maxscaledenom = $matches[1];
            } elseif ($style && is_null($reading) && preg_match('/^MINSCALEDENOM ([0-9\.]+)$/i', $sz, $matches)) {
                $this->minscaledenom = $matches[1];
            } elseif ($style && is_null($reading) && preg_match('/^OPACITY ([0-9]+)$/i', $sz, $matches)) {
                $this->opacity = $matches[1];
            } elseif ($style && is_null($reading) && preg_match('/^OUTLINECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $sz, $matches)) {
                $this->outlinecolor = [$matches[1], $matches[2], $matches[3]];
            } elseif ($style && is_null($reading) && preg_match('/^OUTLINEWIDTH ([0-9\.]+)$/i', $sz, $matches)) {
                $this->outlinewidth = $matches[1];
            } elseif ($style && is_null($reading) && preg_match('/^SIZE ([0-9\.]+)$/i', $sz, $matches)) {
                $this->size = $matches[1];
            } elseif ($style && is_null($reading) && preg_match('/^SYMBOL "(.+)"$/i', $sz, $matches)) {
                $this->symbolname = $matches[1];
            } elseif ($style && is_null($reading) && preg_match('/^WIDTH ([0-9\.]+)$/i', $sz, $matches)) {
                $this->width = $matches[1];
            }
        }
    }
}
