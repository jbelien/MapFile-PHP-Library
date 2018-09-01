<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Model;

/**
 * MapFile Generator - LayerClass (CLASS) Class.
 * [MapFile CLASS clause](https://mapserver.org/mapfile/class.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/class.html
 */
class LayerClass
{
    /** @var \MapFile\Model\Label[] List of labels. */
    private $_labels = [];
    /** @var \MapFile\Model\Style[] List of styles. */
    private $_styles = [];

    /** @var string Enables debugging of the class object. */
    public $debug;
    /** @var string Defines which class a feature belongs to. */
    public $expression;
    /** @var string Allows for grouping of classes. */
    public $group;
    /** @var string Full filename of the legend image for the CLASS. */
    public $keyimage;
    /** @var \MapFile\Model\Leader */
    public $leader;
    /**
     * @var float Minimum scale at which this CLASS is drawn.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $maxscaledenom;
    /**
     * @var float Maximum scale at which this CLASS is drawn.
     *
     * @see http://geography.about.com/cs/maps/a/mapscale.htm
     */
    public $minscaledenom;
    /** @var string Name to use in legends for this class. */
    public $name;
    /** @var string Sets the current display status of the class. */
    public $status;
    /** @var string Template file or URL to use in presenting query results to the user. */
    public $template;
    /** @var string Text to label features in this class with. */
    public $text;
    /** @var string[] */
    public $validation;

    /**
     * Return the list of the labels.
     *
     * @return \MapFile\Model\Label[]
     */
    public function getLabels()
    {
        return $this->_labels;
    }

    /**
     * Return the label matching the index sent as parameter.
     *
     * @param int $i Label Index.
     *
     * @return \MapFile\Model\Label|false false if the index is not found.
     */
    public function getLabel($i)
    {
        return isset($this->_labels[$i]) ? $this->_labels[$i] : false;
    }

    /**
     * Add a new \MapFile\Model\Label to the Class.
     *
     * @param \MapFile\Model\Label $label New Label.
     *
     * @return \MapFile\Model\Label New Label.
     */
    public function addLabel($label = null)
    {
        if (is_null($label)) {
            $label = new Label();
        }
        $count = array_push($this->_labels, $label);

        return $this->_labels[$count - 1];
    }

    /**
     * Remove the \MapFile\Model\Label matching the index sent as parameter.
     *
     * @param int $i Index.
     */
    public function removeLabel($i)
    {
        if (isset($this->_labels[$i])) {
            unset($this->_labels[$i]);
            $this->_labels = array_values($this->_labels);
        }
    }

    /**
     * Return the list of the styles.
     *
     * @return \MapFile\Model\Style[]
     */
    public function getStyles()
    {
        return $this->_styles;
    }

    /**
     * Return the style matching the index sent as parameter.
     *
     * @param int $i Style Index.
     *
     * @return \MapFile\Model\Style|false false if the index is not found.
     */
    public function getStyle($i)
    {
        return isset($this->_styles[$i]) ? $this->_styles[$i] : false;
    }

    /**
     * Add a new \MapFile\Model\Style to the Class.
     *
     * @param \MapFile\Model\Style $style New Style.
     *
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
     *
     * @param int $i Index.
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
     *
     * @param int $i Index.
     */
    public function moveStyleUp($i)
    {
        if (isset($this->_styles[$i]) && $i > 0) {
            $tmp = $this->_styles[$i - 1];
            $this->_styles[$i - 1] = $this->_styles[$i];
            $this->_styles[$i] = $tmp;
        }
    }

    /**
     * Move the \MapFile\Model\Style matching the index sent as parameter down.
     *
     * @param int $i Index.
     */
    public function moveStyleDown($i)
    {
        if (isset($this->_styles[$i]) && $i < (count($this->_styles) - 1)) {
            $tmp = $this->_styles[$i + 1];
            $this->_styles[$i + 1] = $this->_styles[$i];
            $this->_styles[$i] = $tmp;
        }
    }
}
