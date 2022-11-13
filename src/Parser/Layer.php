<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Parser;

use MapFile\Exception\UnsupportedException;
use MapFile\Model\Layer as LayerObject;

class Layer extends Parser
{
    public function parse(string $filename, int $lineNumber = 0): LayerObject
    {
        parent::parse($filename, $lineNumber);

        $layer = new LayerObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^LAYER$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'LAYER';
            } elseif ($this->parsing === 'LAYER' && preg_match('/^BINDVALS$/i', $line) === 1) {
                $bindvalsParser = new BindVals();

                $layer->bindvals = $bindvalsParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $bindvalsParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CLASS$/i', $line) === 1) {
                $classParser = new LayerClass();

                $layer->class->add($classParser->parse($this->file, $this->currentLineIndex - 1));

                $this->currentLineIndex = $classParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CLASSGROUP ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->classgroup = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CLASSITEM ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->classitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CLUSTER$/i', $line) === 1) {
                $clusterParser = new Cluster();

                $layer->cluster = $clusterParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $clusterParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^COMPOSITE$/i', $line) === 1) {
                $compositeParser = new Composite();

                $layer->composite->add($compositeParser->parse($this->file, $this->currentLineIndex - 1));

                $this->currentLineIndex = $compositeParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CONNECTION ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->connection = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CONNECTIONOPTIONS$/i', $line) === 1) {
                $connectionoptionsParser = new ConnectionOptions();

                $layer->connectionoptions = $connectionoptionsParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $connectionoptionsParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CONNECTIONTYPE (CONTOUR|KERNELDENSITY|LOCAL|OGR|ORACLESPATIAL|PLUGIN|POSTGIS|SDE|UNION|UVRASTER|WFS|WMS)$/i', $line, $matches) === 1) {
                $layer->connectiontype = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^DATA ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->data = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^DATA "(.+)$/i', $line, $matches) === 1) {
                $data = $matches[1];

                $this->parsing = 'DATA';
            } elseif ($this->parsing === 'DATA' && preg_match('/^(.+)"$/i', $line, $matches) === 1) {
                $data = $matches[1];
                $layer->data = $data;

                unset($data);

                $this->parsing = 'LAYER';
            } elseif ($this->parsing === 'DATA' && preg_match('/^(.+)$/i', $line, $matches) === 1) {
                $data = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^DEBUG ([0-5]|ON|OFF)$/i', $line, $matches) === 1) {
                if (strtoupper($matches[1]) === 'OFF') {
                    $layer->debug = 0;
                } elseif (strtoupper($matches[1]) === 'ON') {
                    $layer->debug = 1;
                } else {
                    $layer->debug = intval($matches[1]);
                }
            } elseif ($this->parsing === 'LAYER' && preg_match('/^ENCODING ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->encoding = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^EXTENT (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $layer->extent = [
                    floatval($matches[1]),
                    floatval($matches[2]),
                    floatval($matches[3]),
                    floatval($matches[4]),
                ];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FEATURE$/i', $line) === 1) {
                $featureParser = new Feature();

                $layer->feature->add($featureParser->parse($this->file, $this->currentLineIndex - 1));

                $this->currentLineIndex = $featureParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FILTER (\(.+\))$/i', $line, $matches) === 1) {
                $layer->filter = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FILTER ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->filter = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FILTERITEM ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->filteritem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FOOTER ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->footer = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^GEOMTRANSFORM ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->geomtransform = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^GEOMTRANSFORM (\(.+\))$/i', $line, $matches) === 1) {
                $layer->geomtransform = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^GRID$/i', $line) === 1) {
                $gridParser = new Grid();

                $layer->grid = $gridParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $gridParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^GROUP ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->group = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^HEADER ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->header = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^JOIN$/i', $line) === 1) {
                $joinParser = new Join();

                $layer->join->add($joinParser->parse($this->file, $this->currentLineIndex - 1));

                $this->currentLineIndex = $joinParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELCACHE (ON|OFF)$/i', $line, $matches) === 1) {
                $layer->labelcache = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELITEM ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->labelitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELMAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $layer->labelmaxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELMINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $layer->labelminscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELREQUIRES ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->labelrequires = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MASK ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->mask = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MAXFEATURES ([0-9]+)$/i', $line, $matches) === 1) {
                $layer->maxfeatures = intval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MAXGEOWIDTH ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $layer->maxgeowidth = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $layer->maxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^METADATA$/i', $line) === 1) {
                $metadataParser = new Metadata();

                $layer->metadata = $metadataParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $metadataParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MINFEATURESIZE ([0-9]+)$/i', $line, $matches) === 1) {
                $layer->minfeaturesize = intval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MINGEOWIDTH ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $layer->mingeowidth = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $layer->minscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->name = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^OFFSITE ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $layer->offsite = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^OFFSITE ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $layer->offsite = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^OPACITY ([0-9]+)$/i', $line, $matches) === 1) {
                $layer->opacity = intval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^PLUGIN ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->plugin = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^POSTLABELCACHE (TRUE|FALSE)$/i', $line, $matches) === 1) {
                $layer->postlabelcache = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'LAYER' && preg_match('/^PROCESSING ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->processing[] = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^PROJECTION$/i', $line) === 1) {
                $projectionParser = new Projection();

                $layer->projection = $projectionParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $projectionParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^REQUIRES ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->requires = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^SCALETOKEN$/i', $line) === 1) {
                $scaletokenParser = new ScaleToken();

                $layer->scaletoken = $scaletokenParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $scaletokenParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^SIZEUNITS (FEET|INCHES|KILOMETERS|METERS|MILES|NAUTICALMILES|PIXELS)$/i', $line, $matches) === 1) {
                $layer->sizeunits = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^STATUS (ON|OFF|DEFAULT)$/i', $line, $matches) === 1) {
                $layer->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^STYLEITEM ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->styleitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^SYMBOLSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $layer->symbolscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TEMPLATE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->template = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TILEINDEX ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->tileindex = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TILEITEM ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->tileitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TILESRS ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->tilesrs = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TOLERANCE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $layer->tolerance = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TOLERANCEUNITS (PIXELS|FEET|INCHES|KILOMETERS|METERS|MILES|NAUTICALMILES|DD)$/i', $line, $matches) === 1) {
                $layer->toleranceunits = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TRANSFORM (TRUE|FALSE)$/i', $line, $matches) === 1) {
                $layer->transform = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TRANSFORM (UL|UC|UR|CL|CC|CR|LL|LC|LR)$/i', $line, $matches) === 1) {
                $layer->transform = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TYPE (CHART|CIRCLE|LINE|POINT|POLYGON|RASTER|QUERY)$/i', $line, $matches) === 1) {
                $layer->type = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^UNITS (DD|FEET|INCHES|KILOMETERS|METERS|MILES|NAUTICALMILES|PERCENTAGES|PIXELS)$/i', $line, $matches) === 1) {
                $layer->units = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^UTFDATA ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->utfdata = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^UTFITEM ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $layer->utfitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^VALIDATION$/i', $line) === 1) {
                $validationParser = new Validation();

                $layer->validation = $validationParser->parse($this->file, $this->currentLineIndex - 1);

                $this->currentLineIndex = $validationParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^END( # LAYER)?$/i', $line) === 1) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $layer;
    }
}
