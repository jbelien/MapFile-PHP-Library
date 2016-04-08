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

/**
 * MapFile library SPL autoloader.
 * @param string $classname The name of the class to load
 */
function MapFileAutoload($classname) {
  list($namespace, $class) = explode('\\', $classname);
  $filename = __DIR__.'/'.strtolower($class).'.php';
  if (is_readable($filename)) { require $filename; }
}

spl_autoload_register('MapFileAutoload', TRUE, TRUE);