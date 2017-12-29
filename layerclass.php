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
 * MapFile Generator - LayerClass (CLASS) Class.
 * [MapFile CLASS clause](http://mapserver.org/mapfile/class.html).
 *
 * @author Jonathan Beliën <jbe@geo6.be>
 *
 * @link http://mapserver.org/mapfile/class.html
 */
class layerclass
{
    /** @var \MapFile\Label[] List of labels. */
    private $_labels = [];
    /** @var \MapFile\Style[] List of styles. */
    private $_styles = [];

    /** @var string Defines which class a feature belongs to. */
    public $expression;
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
    /** @var string Name to use in legends for this class. */
    public $name;
    /** @var string Text to label features in this class with. */
    public $text;

    /**
     * Constructor.
     *
     * @param string[] $class Array containing MapFile CLASS clause.
     *
     * @todo Must read a MapFile CLASS clause without passing by an Array.
     */
    public function __construct($class = null)
    {
        if (!is_null($class)) {
            $this->read($class);
        }
    }

    /**
     * Return the list of the labels.
     *
     * @return \MapFile\Label[]
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
     * @return \MapFile\Label|false false if the index is not found.
     */
    public function getLabel($i)
    {
        return isset($this->_labels[$i]) ? $this->_labels[$i] : false;
    }

    /**
     * Return the list of the styles.
     *
     * @return \MapFile\Style[]
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
     * @return \MapFile\Style|false false if the index is not found.
     */
    public function getStyle($i)
    {
        return isset($this->_styles[$i]) ? $this->_styles[$i] : false;
    }

    /**
     * Add a new \MapFile\Label to the Class.
     *
     * @param \MapFile\Label $label New Label.
     *
     * @return \MapFile\Label New Label.
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
     * Remove the \MapFile\Label matching the index sent as parameter.
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
     * Move the \MapFile\Style matching the index sent as parameter up.
     *
     * @param int $i Index.
     */

    /**
     * Add a new \MapFile\Style to the Class.
     *
     * @param \MapFile\Style $style New Style.
     *
     * @return \MapFile\Style New Style.
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
     * Remove the \MapFile\Style matching the index sent as parameter.
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
     * Move the \MapFile\Style matching the index sent as parameter up.
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
     * Move the \MapFile\Style matching the index sent as parameter down.
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

    /**
     * Write a valid MapFile CLASS clause.
     *
     * @return string
     *
     * @uses \MapFile\Label::write()
     * @uses \MapFile\Style::write()
     */
    public function write()
    {
        $class = '    CLASS'.PHP_EOL;
        if (!empty($this->name)) {
            $class .= '      NAME "'.$this->name.'"'.PHP_EOL;
        }
        if (!empty($this->expression) && preg_match('/^\(.+\)$/i', $this->expression)) {
            $class .= '      EXPRESSION '.$this->expression.PHP_EOL;
        }
        if (!empty($this->expression) && !preg_match('/^\(.+\)$/i', $this->expression)) {
            $class .= '      EXPRESSION "'.$this->expression.'"'.PHP_EOL;
        }
        if (!is_null($this->minscaledenom)) {
            $class .= '      MINSCALEDENOM '.floatval($this->minscaledenom).PHP_EOL;
        }
        if (!is_null($this->maxscaledenom)) {
            $class .= '      MAXSCALEDENOM '.floatval($this->maxscaledenom).PHP_EOL;
        }
        if (!empty($this->text)) {
            $class .= '      TEXT "'.$this->text.'"'.PHP_EOL;
        }
        foreach ($this->_styles as $style) {
            $class .= $style->write();
        }
        foreach ($this->_labels as $label) {
            $class .= $label->write(3);
        }
        $class .= '    END # CLASS'.PHP_EOL;

        return $class;
    }

    /**
     * Read a valid MapFile CLASS clause (as array).
     *
     * @param string[] $array MapFile CLASS clause splitted in an array.
     *
     * @uses \MapFile\Label::read()
     * @uses \MapFile\Style::read()
     *
     * @todo Must read a MapFile CLASS clause without passing by an Array.
     */
    private function read($array)
    {
        $class = false;
        $reading = null;

        foreach ($array as $_sz) {
            $sz = trim($_sz);

            if (preg_match('/^CLASS$/i', $sz)) {
                $class = true;
            } elseif ($class && is_null($reading) && preg_match('/^END( # CLASS)?$/i', $sz)) {
                $class = false;
            } elseif ($class && is_null($reading) && preg_match('/^LABEL$/i', $sz)) {
                $reading = 'LABEL';
                $label[] = $sz;
            } elseif ($class && $reading == 'LABEL' && preg_match('/^END( # LABEL)?$/i', $sz)) {
                $label[] = $sz;
                $this->addLabel(new Label($label));
                $reading = null;
                unset($label);
            } elseif ($class && $reading == 'LABEL') {
                $label[] = $sz;
            } elseif ($class && is_null($reading) && preg_match('/^STYLE$/i', $sz)) {
                $reading = 'STYLE';
                $style[] = $sz;
            } elseif ($class && $reading == 'STYLE' && preg_match('/^END( # STYLE)?$/i', $sz)) {
                $style[] = $sz;
                $this->addStyle(new Style($style));
                $reading = null;
                unset($style);
            } elseif ($class && $reading == 'STYLE') {
                $style[] = $sz;
            } elseif ($class && is_null($reading) && preg_match('/^EXPRESSION "(.+)"$/i', $sz, $matches)) {
                $this->expression = $matches[1];
            } elseif ($class && is_null($reading) && preg_match('/^EXPRESSION (\(.+\))$/i', $sz, $matches)) {
                $this->expression = $matches[1];
            } elseif ($class && is_null($reading) && preg_match('/^MAXSCALEDENOM ([0-9\.]+)$/i', $sz, $matches)) {
                $this->maxscaledenom = $matches[1];
            } elseif ($class && is_null($reading) && preg_match('/^MINSCALEDENOM ([0-9\.]+)$/i', $sz, $matches)) {
                $this->minscaledenom = $matches[1];
            } elseif ($class && is_null($reading) && preg_match('/^NAME "(.+)"$/i', $sz, $matches)) {
                $this->name = $matches[1];
            } elseif ($class && is_null($reading) && preg_match('/^TEXT "(.+)"$/i', $sz, $matches)) {
                $this->text = $matches[1];
            }
        }
    }
}
