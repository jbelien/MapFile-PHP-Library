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
 * MapFile Generator - Join (JOIN) Class.
 * [MapFile JOIN clause](https://mapserver.org/mapfile/join.html).
 *
 * @author Jonathan Beliën
 *
 * @link https://mapserver.org/mapfile/join.html
 */
class Join extends MapFileObject
{
    /** @var null|string Parameters required for the join table’s database connection (not required for DBF or CSV joins). */
    public $connection;
    /** @var null|string Type of connection (not required for DBF joins). */
    public $connectiontype;
    /** @var null|string Template to use after a layer’s set of results have been sent. */
    public $footer;
    /** @var null|string Join column in the dataset. */
    public $from;
    /** @var null|string Template to use before a layer’s set of results have been sent. */
    public $header;
    /** @var null|string Unique name for this join. */
    public $name;
    /** @var null|string For file-based joins this is the name of XBase or comma delimited file (relative to the location of the mapfile) to join TO. For PostgreSQL support this is the name of the PostgreSQL table to join TO. */
    public $table;
    /** @var null|string Template to use with one-to-many joins. */
    public $template;
    /** @var null|string Join column in the table to be joined. */
    public $to;
    /** @var null|string The type of join. */
    public $type;
}
