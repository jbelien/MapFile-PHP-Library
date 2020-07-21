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
use MapFile\Model\Map as MapObject;

class Map extends Parser
{
    public function parse($content = null): MapObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $map = new MapObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^MAP$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'MAP';
            } elseif ($this->parsing === 'MAP' && preg_match('/^ANGLE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $map->angle = floatval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^CONFIG ["\'](.+)["\'] ["\'](.+)["\']$/i', $line, $matches)) {
                $map->config[$matches[1]] = $matches[2];
            } elseif ($this->parsing === 'MAP' && preg_match('/^DATAPATTERN (\/.+\/[a-z]*)$/i', $line, $matches)) {
                $map->datapattern = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^DEBUG ([0-5]|ON|OFF)$/i', $line, $matches)) {
                if (strtoupper($matches[1]) === 'OFF') {
                    $map->debug = 0;
                } elseif (strtoupper($matches[1]) === 'ON') {
                    $map->debug = 1;
                } else {
                    $map->debug = intval($matches[1]);
                }
            } elseif ($this->parsing === 'MAP' && preg_match('/^DEFRESOLUTION ([0-9]+)$/i', $line, $matches)) {
                $map->angle = intval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^EXTENT (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $map->extent = [
                    floatval($matches[1]),
                    floatval($matches[2]),
                    floatval($matches[3]),
                    floatval($matches[4]),
                ];
            } elseif ($this->parsing === 'MAP' && preg_match('/^FONTSET ["\'](.+)["\']$/i', $line, $matches)) {
                $map->fontset = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^IMAGECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $map->imagecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'MAP' && preg_match('/^IMAGECOLOR ["\'](#.+)["\']$/i', $line, $matches)) {
                $map->imagecolor = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^IMAGETYPE (.+)$/i', $line, $matches)) {
                $map->imagetype = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^INCLUDE ["\'](.+)["\']$/i', $line, $matches)) {
                $map->include[] = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^LAYER$/i', $line)) {
                $layerParser = new Layer($this->file, $this->currentLineIndex - 1);
                $layer = $layerParser->parse($this->content);

                $map->layer->add($layer);

                $this->currentLineIndex = $layerParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^LEGEND$/i', $line)) {
                $legendParser = new Legend($this->file, $this->currentLineIndex - 1);
                $legend = $legendParser->parse($this->content);

                $map->legend = $legend;

                $this->currentLineIndex = $legendParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^MAXSIZE ([0-9]+)$/i', $line, $matches)) {
                $map->maxsize = intval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches)) {
                $map->name = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^OUTPUTFORMAT$/i', $line)) {
                $outputformatParser = new OutputFormat($this->file, $this->currentLineIndex - 1);
                $outputformat = $outputformatParser->parse($this->content);

                $map->outputformat = $outputformat;

                $this->currentLineIndex = $outputformatParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^PROJECTION$/i', $line)) {
                $projectionParser = new Projection($this->file, $this->currentLineIndex - 1);
                $projection = $projectionParser->parse($this->content);

                $map->projection = $projection;

                $this->currentLineIndex = $projectionParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^QUERYMAP$/i', $line)) {
                $querymapParser = new QueryMap($this->file, $this->currentLineIndex - 1);
                $querymap = $querymapParser->parse($this->content);

                $map->querymap = $querymap;

                $this->currentLineIndex = $querymapParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^REFERENCE$/i', $line)) {
                $referenceParser = new Reference($this->file, $this->currentLineIndex - 1);
                $reference = $referenceParser->parse($this->content);

                $map->reference = $reference;

                $this->currentLineIndex = $querymapParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^RESOLUTION ([0-9]+)$/i', $line, $matches)) {
                $map->resolution = intval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^SCALEBAR$/i', $line)) {
                $scalebarParser = new Scalebar($this->file, $this->currentLineIndex - 1);
                $scalebar = $scalebarParser->parse($this->content);

                $map->scalebar = $scalebar;

                $this->currentLineIndex = $scalebarParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^SCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $layer->scaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^SHAPEPATH ["\'](.+)["\']$/i', $line, $matches)) {
                $map->shapepath = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^SIZE ([0-9]+) ([0-9]+)$/i', $line, $matches)) {
                $map->size = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'MAP' && preg_match('/^STATUS (ON|OFF)$/i', $line, $matches)) {
                $map->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^SYMBOL$/i', $line)) {
                $symbolParser = new Symbol($this->file, $this->currentLineIndex - 1);
                $symbol = $symbolParser->parse($this->content);

                $map->symbol->add($symbol);

                $this->currentLineIndex = $symbolParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^SYMBOLSET ["\'](.+)["\']$/i', $line, $matches)) {
                $map->symbolset = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^TEMPLATEPATTERN (\/.+\/[a-z]*)$/i', $line, $matches)) {
                $map->templatepattern = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^UNITS (DD|FEET|INCHES|KILOMETERS|METERS|MILES|NAUTICALMILE)$/i', $line, $matches)) {
                $map->units = strtoupper($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^WEB$/i', $line)) {
                $webParser = new Web($this->file, $this->currentLineIndex - 1);
                $web = $webParser->parse($this->content);

                $map->web = $web;

                $this->currentLineIndex = $webParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^END( # MAP)?$/i', $line)) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $map;
    }
}
