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
 * MapFile Generator - OutputFormat (OUTPUTFORMAT) Class.
 * [MapFile OUTPUTFORMAT clause](https://mapserver.org/mapfile/outputformat.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/outputformat.html
 */
class OutputFormat
{
    /** @var string The name of the driver to use to generate this output format. */
    public $driver;
    /** @var string Provide the extension to use when creating files of this type. */
    public $extension;
    /** @var string[] Provides a driver or format specific option. */
    public $formatoption = [];
    /** @var string Selects the imaging mode in which the output is generated. */
    public $imagemode;
    /** @var string Provide the mime type to be used when returning results over the web. */
    public $mimetype;
    /** @var string The name to use in the IMAGETYPE keyword of the map file to select this output format. */
    public $name;
    /** @var string Indicates whether transparency should be enabled for this format. */
    public $transparent;
}
