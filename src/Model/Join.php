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
class Join
{
    /** @var string Parameters required for the join table’s database connection (not required for DBF or CSV joins). */
    public $connection;
    /** @var string Type of connection (not required for DBF joins). */
    public $connectiontype;
    /** @var string Template to use after a layer’s set of results have been sent. */
    public $footer;
    /** @var string Join column in the dataset. */
    public $from;
    /** @var string Template to use before a layer’s set of results have been sent. */
    public $header;
    /** @var string Unique name for this join. */
    public $name;
    /** @var string For file-based joins this is the name of XBase or comma delimited file (relative to the location of the mapfile) to join TO. For PostgreSQL support this is the name of the PostgreSQL table to join TO. */
    public $table;
    /** @var string Template to use with one-to-many joins. */
    public $template;
    /** @var string Join column in the table to be joined. */
    public $to;
    /** @var string The type of join. */
    public $type;
}
