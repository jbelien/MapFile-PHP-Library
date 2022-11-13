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
 * MapFile Generator - Web (WEB) Class.
 * [MapFile WEB clause](https://mapserver.org/mapfile/web.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/web.html
 */
class Web extends MapFileObject
{
    /** @var null|string Format of the interface output, using MapServer CGI. */
    public $browseformat;
    /** @var null|string URL to forward users to if a query fails. */
    public $empty;
    /** @var null|string URL to forward users to if an error occurs. */
    public $error;
    /** @var null|string Template to use AFTER anything else is sent. */
    public $footer;
    /** @var null|string Template to use BEFORE everything else has been sent. */
    public $header;
    /** @var null|string Path to the temporary directory for writing temporary files and images. */
    public $imagepath;
    /** @var null|string Base URL for IMAGEPATH. */
    public $imageurl;
    /** @var null|string Format of the legend output, using MapServer CGI. */
    public $legendformat;
    /** @var null|float Minimum scale at which this interface is valid. */
    public $maxscaledenom;
    /** @var null|string Template to be used if below the minimum scale for the app. */
    public $maxtemplate;
    /** @var array<string,string> This keyword allows for arbitrary data to be stored as name value pairs. */
    public $metadata = [];
    /** @var null|float Maximum scale at which this interface is valid. */
    public $minscaledenom;
    /** @var null|string Template to be used if above the maximum scale for the app. */
    public $mintemplate;
    /** @var null|string Format of the query output. */
    public $queryformat;
    /** @var null|string Template file or URL to use in presenting the results to the user in an interactive mode. */
    public $template;
    /**
     * @var null|string Path for storing temporary files.
     *
     * @version 6.0
     */
    public $temppath;
    /** @var null|array<string,string> */
    public $validation;
}
