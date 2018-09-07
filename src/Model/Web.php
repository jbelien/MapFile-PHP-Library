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
class Web
{
    /** @var string Format of the interface output, using MapServer CGI. */
    public $browseformat;
    /** @var string URL to forward users to if a query fails. */
    public $empty;
    /** @var string URL to forward users to if an error occurs. */
    public $error;
    /** @var string Template to use AFTER anything else is sent. */
    public $footer;
    /** @var string Template to use BEFORE everything else has been sent. */
    public $header;
    /** @var string Path to the temporary directory for writing temporary files and images. */
    public $imagepath;
    /** @var string Base URL for IMAGEPATH. */
    public $imageurl;
    /** @var string Format of the legend output, using MapServer CGI. */
    public $legendformat;
    /** @var float Minimum scale at which this interface is valid. */
    public $maxscaledenom;
    /** @var string Template to be used if below the minimum scale for the app. */
    public $maxtemplate;
    /** @var string[] This keyword allows for arbitrary data to be stored as name value pairs. */
    public $metadata = [];
    /** @var float Maximum scale at which this interface is valid. */
    public $minscaledenom;
    /** @var string Template to be used if above the maximum scale for the app. */
    public $mintemplate;
    /** @var string Format of the query output. */
    public $queryformat;
    /** @var string Template file or URL to use in presenting the results to the user in an interactive mode. */
    public $template;
    /** @var string Path for storing temporary files. */
    public $temppath;
    /** @var string[] */
    public $validation;
}
