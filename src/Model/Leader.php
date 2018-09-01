<?php

declare (strict_types = 1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */
namespace MapFile\Model;

/**
 * MapFile Generator - Leader (LEADER) Class.
 * [MapFile LEADER clause](https://mapserver.org/mapfile/leader.html).
 * @package MapFile
 * @author Jonathan Beliën
 * @link https://mapserver.org/mapfile/leader.html
 */
class Leader
{
    /** @var \MapFile\Model\Style[] List of styles. */
    private $_styles = [];

    /** @var integer Specifies the number of pixels between positions that are tested for a label line. */
    public $gridstep;
    /** @var integer Specifies the maximum distance in pixels from the normal label location that a leader line can be drawn.  */
    public $maxdistance;
    /** @var string Selects the imaging mode in which the output is generated. */

    /**
     * Return the list of the styles.
     * @return \MapFile\Model\Style[]
     */
    public function getStyles()
    {
        return $this->_styles;
    }
    /**
     * Return the style matching the index sent as parameter.
     * @param integer $i Style Index.
     * @return \MapFile\Model\Style|false false if the index is not found.
     */
    public function getStyle($i)
    {
        return (isset($this->_styles[$i]) ? $this->_styles[$i] : false);
    }
    /**
     * Add a new \MapFile\Model\Style to the Class.
     * @param \MapFile\Model\Style $style New Style.
     * @return \MapFile\Model\Style New Style.
     */
    public function addStyle($style = null)
    {
        if (is_null($style)) {
            $style = new Style();
        }
        $count = array_push($this->_styles, $style);
        return $this->_styles[$count - 1];
    }
    /**
     * Remove the \MapFile\Model\Style matching the index sent as parameter.
     * @param integer $i Index.
     */
    public function removeStyle($i)
    {
        if (isset($this->_styles[$i])) {
            unset($this->_styles[$i]);
            $this->_styles = array_values($this->_styles);
        }
    }
    /**
     * Move the \MapFile\Model\Style matching the index sent as parameter up.
     * @param integer $i Index.
     */
    public function moveStyleUp($i)
    {
        if (isset($this->_styles[$i]) && $i > 0) {
            $tmp                   = $this->_styles[$i - 1];
            $this->_styles[$i - 1] = $this->_styles[$i];
            $this->_styles[$i]     = $tmp;
        }
    }
    /**
     * Move the \MapFile\Model\Style matching the index sent as parameter down.
     * @param integer $i Index.
     */
    public function moveStyleDown($i)
    {
        if (isset($this->_styles[$i]) && $i < (count($this->_styles) - 1)) {
            $tmp                   = $this->_styles[$i + 1];
            $this->_styles[$i + 1] = $this->_styles[$i];
            $this->_styles[$i]     = $tmp;
        }
    }
}
