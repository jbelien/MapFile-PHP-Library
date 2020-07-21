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
    public function parse($content = null): LayerObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $layer = new LayerObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^LAYER$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'LAYER';
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CLASS$/i', $line)) {
                $classParser = new LayerClass($this->file, $this->currentLineIndex - 1);
                $class = $classParser->parse();

                $layer->class->add($class);

                $this->currentLineIndex = $classParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CLASSGROUP ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->classgroup = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CLASSITEM ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->classitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CLUSTER$/i', $line)) {
                $clusterParser = new Cluster($this->file, $this->currentLineIndex - 1);
                $cluster = $clusterParser->parse();

                $layer->cluster = $cluster;

                $this->currentLineIndex = $clusterParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^COMPOSITE$/i', $line)) {
                $compositeParser = new Composite($this->file, $this->currentLineIndex - 1);
                $composite = $compositeParser->parse();

                $layer->composite->add($composite);

                $this->currentLineIndex = $compositeParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CONNECTION ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->connection = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^CONNECTIONTYPE (CONTOUR|KERNELDENSITY|LOCAL|OGR|ORACLESPATIAL|PLUGIN|POSTGIS|SDE|UNION|UVRASTER|WFS|WMS)$/i', $line, $matches)) {
                $layer->connectiontype = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^DATA ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->data = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^DATA "(.+)$/i', $line, $matches)) {
                $data = $matches[1];

                $this->parsing = 'DATA';
            } elseif ($this->parsing === 'DATA' && preg_match('/^(.+)"$/i', $line, $matches)) {
                $data .= $matches[1];
                $layer->data = $data;

                unset($data);

                $this->parsing = 'LAYER';
            } elseif ($this->parsing === 'DATA' && preg_match('/^(.+)$/i', $line, $matches)) {
                $data .= $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^DEBUG ([0-5]|ON|OFF)$/i', $line, $matches)) {
                if (strtoupper($matches[1]) === 'OFF') {
                    $layer->debug = 0;
                } elseif (strtoupper($matches[1]) === 'ON') {
                    $layer->debug = 1;
                } else {
                    $layer->debug = intval($matches[1]);
                }
            } elseif ($this->parsing === 'LAYER' && preg_match('/^ENCODING ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->encoding = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^EXTENT (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->extent = [
                    floatval($matches[1]),
                    floatval($matches[2]),
                    floatval($matches[3]),
                    floatval($matches[4]),
                ];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FEATURE$/i', $line)) {
                $featureParser = new Feature($this->file, $this->currentLineIndex - 1);
                $feature = $featureParser->parse();

                $layer->feature->add($feature);

                $this->currentLineIndex = $featureParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FILTER (\(.+\))$/i', $line, $matches)) {
                $layer->filer = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FILTER ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->filer = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FILTERITEM ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->filteritem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^FOOTER ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->footer = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^GEOMTRANSFORM ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->geomtransform = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^GEOMTRANSFORM (\(.+\))$/i', $line, $matches)) {
                $layer->geomtransform = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^GRID$/i', $line)) {
                $gridParser = new Grid($this->file, $this->currentLineIndex - 1);
                $grid = $gridParser->parse();

                $layer->grid = $grid;

                $this->currentLineIndex = $gridParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^GROUP ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->group = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^HEADER ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->header = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^JOIN$/i', $line)) {
                $joinParser = new Join($this->file, $this->currentLineIndex - 1);
                $join = $joinParser->parse();

                $layer->join->add($join);

                $this->currentLineIndex = $joinParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELCACHE (ON|OFF)$/i', $line, $matches)) {
                $layer->labelcache = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELITEM ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->labelitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELMAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->labelmaxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELMINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->labelminscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^LABELREQUIRES ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->labelrequires = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MASK ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->mask = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MAXFEATURES ([0-9]+)$/i', $line, $matches)) {
                $layer->maxfeatures = intval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MAXGEOWIDTH ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->maxgeowidth = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MAXSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->maxscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^METADATA$/i', $line)) {
                $metadataParser = new Metadata($this->file, $this->currentLineIndex - 1);
                $metadata = $metadataParser->parse();

                $layer->metadata = $metadata;

                $this->currentLineIndex = $metadataParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MINGEOWIDTH ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->mingeowidth = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^MINSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->minscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->name = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^OFFSITE ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $layer->offsite = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^OFFSITE ["\'](#.+)["\']$/i', $line, $matches)) {
                $layer->offsite = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^OPACITY ([0-9]+)$/i', $line, $matches)) {
                $layer->opacity = intval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^PLUGIN ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->plugin = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^POSTLABELCACHE (TRUE|FALSE)$/i', $line, $matches)) {
                $layer->postlabelcache = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'LAYER' && preg_match('/^PROCESSING ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->processing[] = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^PROJECTION$/i', $line)) {
                $projectionParser = new Projection($this->file, $this->currentLineIndex - 1);
                $projection = $projectionParser->parse();

                $layer->projection = $projection;

                $this->currentLineIndex = $projectionParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^REQUIRES ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->requires = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^SCALETOKEN$/i', $line)) {
                $scaletokenParser = new ScaleToken($this->file, $this->currentLineIndex - 1);
                $scaletoken = $scaletokenParser->parse();

                $layer->scaletoken = $scaletoken;

                $this->currentLineIndex = $scaletokenParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^SIZEUNITS (FEET|INCHES|KILOMETERS|METERS|MILES|NAUTICALMILES|PIXELS)$/i', $line, $matches)) {
                $layer->sizeunits = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^STATUS (ON|OFF|DEFAULT)$/i', $line, $matches)) {
                $layer->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^STYLEITEM ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->styleitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^SYMBOLSCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->symbolscaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TEMPLATE ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->template = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TILEINDEX ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->tileindex = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TILEITEM ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->tileitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TILESRS ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->tilesrs = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TOLERANCE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->tolerance = floatval($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TOLERANCEUNITS (PIXELS|FEET|INCHES|KILOMETERS|METERS|MILES|NAUTICALMILES|DD)$/i', $line, $matches)) {
                $layer->toleranceunits = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TRANSFORM (TRUE|FALSE)$/i', $line, $matches)) {
                $layer->transform = (strtoupper($matches[1]) === 'TRUE');
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TRANSFORM (UL|UC|UR|CL|CC|CR|LL|LC|LR)$/i', $line, $matches)) {
                $layer->transform = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^TYPE (CHART|CIRCLE|LINE|POINT|POLYGON|RASTER|QUERY)$/i', $line, $matches)) {
                $layer->type = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^UNITS (DD|FEET|INCHES|KILOMETERS|METERS|MILES|NAUTICALMILES|PERCENTAGES|PIXELS)$/i', $line, $matches)) {
                $layer->units = strtoupper($matches[1]);
            } elseif ($this->parsing === 'LAYER' && preg_match('/^UTFDATA ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->utfdata = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^UTFITEM ["\'](.+)["\']$/i', $line, $matches)) {
                $layer->utfitem = $matches[1];
            } elseif ($this->parsing === 'LAYER' && preg_match('/^VALIDATION$/i', $line)) {
                $validationParser = new Validation($this->file, $this->currentLineIndex - 1);
                $validation = $validationParser->parse();

                $layer->validation = $validation;

                $this->currentLineIndex = $validationParser->lineEnd;
            } elseif ($this->parsing === 'LAYER' && preg_match('/^END( # LAYER)?$/i', $line)) {
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
