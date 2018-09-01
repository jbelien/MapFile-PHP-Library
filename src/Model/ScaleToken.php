<?php

declare (strict_types = 1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */
namespace MapFile\Model;

/**
 * MapFile Generator - ScaleToken (SCALETOKEN) Class.
 * @package MapFile
 * @author Jonathan Beliën
 */
class ScaleToken
{
    /** @var string[] */
    private $values = [];

    /** @var string */
    public $name;

    /**
     * Set a `values` property.
     * @param string $key
     * @param string $value
     */
    public function setValue($key, $value): void
    {
        $this->values[$key] = $value;
    }

    /**
     * Return the value matching the key sent as parameter.
     * @param string $key Value Key.
     * @return string|false false if the key is not found
     */
    public function getValue($key)
    {
        return (isset($this->values[$key]) ? $this->values[$key] : false);
    }

    /**
     * Remove the value matching the key sent as parameter.
     * @param string $key Value Key.
     */
    public function removeValue($key): void
    {
        if (isset($this->values[$key])) {
            unset($this->values[$key]);
        }
    }
}
