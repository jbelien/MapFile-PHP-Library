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
    public function parseBlock(?array $content = null): MapObject
    {
        if (!is_null($content)) {
            $this->content = $content;
        }

        $map = new MapObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^MAP$/i', $line) === 1) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'MAP';
            } elseif ($this->parsing === 'MAP' && preg_match('/^ANGLE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $map->angle = floatval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^CONFIG ["\'](.+)["\'] ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $map->config[$matches[1]] = $matches[2];
            } elseif ($this->parsing === 'MAP' && preg_match('/^DATAPATTERN (\/.+\/[a-z]*)$/i', $line, $matches) === 1) {
                $map->datapattern = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^DEBUG ([0-5]|ON|OFF)$/i', $line, $matches) === 1) {
                if (strtoupper($matches[1]) === 'OFF') {
                    $map->debug = 0;
                } elseif (strtoupper($matches[1]) === 'ON') {
                    $map->debug = 1;
                } else {
                    $map->debug = intval($matches[1]);
                }
            } elseif ($this->parsing === 'MAP' && preg_match('/^DEFRESOLUTION ([0-9]+)$/i', $line, $matches) === 1) {
                $map->angle = intval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^EXTENT (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?) (-?[0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $map->extent = [
                    floatval($matches[1]),
                    floatval($matches[2]),
                    floatval($matches[3]),
                    floatval($matches[4]),
                ];
            } elseif ($this->parsing === 'MAP' && preg_match('/^FONTSET ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $map->fontset = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^IMAGECOLOR ([0-9]+) ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $map->imagecolor = [
                    intval($matches[1]),
                    intval($matches[2]),
                    intval($matches[3]),
                ];
            } elseif ($this->parsing === 'MAP' && preg_match('/^IMAGECOLOR ["\'](#.+)["\']$/i', $line, $matches) === 1) {
                $map->imagecolor = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^IMAGETYPE (.+)$/i', $line, $matches) === 1) {
                $map->imagetype = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^INCLUDE ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $map->include[] = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^LAYER$/i', $line) === 1) {
                $layerParser = new Layer($this->file, $this->currentLineIndex - 1);
                $layer = $layerParser->parseBlock($this->content);

                $map->layer->add($layer);

                $this->currentLineIndex = $layerParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^LEGEND$/i', $line) === 1) {
                $legendParser = new Legend($this->file, $this->currentLineIndex - 1);
                $legend = $legendParser->parseBlock($this->content);

                $map->legend = $legend;

                $this->currentLineIndex = $legendParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^MAXSIZE ([0-9]+)$/i', $line, $matches) === 1) {
                $map->maxsize = intval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^NAME ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $map->name = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^OUTPUTFORMAT$/i', $line) === 1) {
                $outputformatParser = new OutputFormat($this->file, $this->currentLineIndex - 1);
                $outputformat = $outputformatParser->parseBlock($this->content);

                $map->outputformat->add($outputformat);

                $this->currentLineIndex = $outputformatParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^PROJECTION$/i', $line) === 1) {
                $projectionParser = new Projection($this->file, $this->currentLineIndex - 1);
                $projection = $projectionParser->parseBlock($this->content);

                $map->projection = $projection;

                $this->currentLineIndex = $projectionParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^QUERYMAP$/i', $line) === 1) {
                $querymapParser = new QueryMap($this->file, $this->currentLineIndex - 1);
                $querymap = $querymapParser->parseBlock($this->content);

                $map->querymap = $querymap;

                $this->currentLineIndex = $querymapParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^REFERENCE$/i', $line) === 1) {
                $referenceParser = new Reference($this->file, $this->currentLineIndex - 1);
                $reference = $referenceParser->parseBlock($this->content);

                $map->reference = $reference;

                $this->currentLineIndex = $referenceParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^RESOLUTION ([0-9]+)$/i', $line, $matches) === 1) {
                $map->resolution = intval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^SCALEBAR$/i', $line) === 1) {
                $scalebarParser = new Scalebar($this->file, $this->currentLineIndex - 1);
                $scalebar = $scalebarParser->parseBlock($this->content);

                $map->scalebar = $scalebar;

                $this->currentLineIndex = $scalebarParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^SCALEDENOM ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) === 1) {
                $map->scaledenom = floatval($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^SHAPEPATH ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $map->shapepath = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^SIZE ([0-9]+) ([0-9]+)$/i', $line, $matches) === 1) {
                $map->size = [
                    intval($matches[1]),
                    intval($matches[2]),
                ];
            } elseif ($this->parsing === 'MAP' && preg_match('/^STATUS (ON|OFF)$/i', $line, $matches) === 1) {
                $map->status = strtoupper($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^SYMBOL$/i', $line) === 1) {
                $symbolParser = new Symbol($this->file, $this->currentLineIndex - 1);
                $symbol = $symbolParser->parseBlock($this->content);

                $map->symbol->add($symbol);

                $this->currentLineIndex = $symbolParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^SYMBOLSET ["\'](.+)["\']$/i', $line, $matches) === 1) {
                $map->symbolset = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^TEMPLATEPATTERN (\/.+\/[a-z]*)$/i', $line, $matches) === 1) {
                $map->templatepattern = $matches[1];
            } elseif ($this->parsing === 'MAP' && preg_match('/^UNITS (DD|FEET|INCHES|KILOMETERS|METERS|MILES|NAUTICALMILE)$/i', $line, $matches) === 1) {
                $map->units = strtoupper($matches[1]);
            } elseif ($this->parsing === 'MAP' && preg_match('/^WEB$/i', $line) === 1) {
                $webParser = new Web($this->file, $this->currentLineIndex - 1);
                $web = $webParser->parseBlock($this->content);

                $map->web = $web;

                $this->currentLineIndex = $webParser->lineEnd;
            } elseif ($this->parsing === 'MAP' && preg_match('/^END( # MAP)?$/i', $line) === 1) {
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
