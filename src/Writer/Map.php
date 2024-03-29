<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

use MapFile\Model\Map as MapObject;

class Map extends Writer
{
    public function __construct(MapObject $map, int $indentSize = 0, string $indent = self::WRITER_INDENT)
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'MAP'.PHP_EOL;

        $this->text .= self::getTextRaw('ANGLE', $map->angle, $indentSize + 1, $indent);

        foreach ($map->config as $key => $value) {
            $this->text .= str_repeat($indent, $indentSize + 1);
            $this->text .= 'CONFIG "'.$key.'" "'.$value.'"';
            $this->text .= PHP_EOL;
        }

        $this->text .= self::getTextRaw('DATAPATTERN', $map->datapattern, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('DEBUG', $map->debug, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('DEFRESOLUTION', $map->defresolution, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('EXTENT', $map->extent, $indentSize + 1, $indent);
        $this->text .= self::getTextString('FONTSET', $map->fontset, $indentSize + 1, $indent);
        $this->text .= is_array($map->imagecolor) ? self::getTextArray('IMAGECOLOR', $map->imagecolor, 1) : self::getTextString('IMAGECOLOR', $map->imagecolor, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('IMAGETYPE', $map->imagetype, $indentSize + 1, $indent);

        foreach ($map->layer as $layer) {
            $this->text .= (new Layer($layer, $indentSize + 1, $indent))->text;
        }

        if (!is_null($map->legend)) {
            $this->text .= (new Legend($map->legend, $indentSize + 1, $indent))->text;
        }

        $this->text .= self::getTextRaw('MAXSIZE', $map->maxsize, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $map->name, $indentSize + 1, $indent);

        foreach ($map->outputformat as $outputformat) {
            $this->text .= (new OutputFormat($outputformat, $indentSize + 1, $indent))->text;
        }

        if (!is_null($map->projection)) {
            $this->text .= (new Projection($map->projection, $indentSize + 1, $indent))->text;
        }

        if (!is_null($map->querymap)) {
            $this->text .= (new QueryMap($map->querymap, $indentSize + 1, $indent))->text;
        }

        if (!is_null($map->reference)) {
            $this->text .= (new Reference($map->reference, $indentSize + 1, $indent))->text;
        }

        $this->text .= self::getTextRaw('RESOLUTION', $map->resolution, $indentSize + 1, $indent);

        if (!is_null($map->scalebar)) {
            $this->text .= (new Scalebar($map->scalebar, $indentSize + 1, $indent))->text;
        }

        $this->text .= self::getTextRaw('SCALEDENOM', $map->scaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('SHAPEPATH', $map->shapepath, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('SIZE', $map->size, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STATUS', $map->status, $indentSize + 1, $indent);

        foreach ($map->symbol as $symbol) {
            $this->text .= (new Symbol($symbol, $indentSize + 1, $indent))->text;
        }

        $this->text .= self::getTextString('SYMBOLSET', $map->symbolset, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TEMPLATEPATTERN', $map->templatepattern, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('UNITS', $map->units, $indentSize + 1, $indent);

        if (!is_null($map->web)) {
            $this->text .= (new Web($map->web, $indentSize + 1, $indent))->text;
        }

        if (count($map->include) > 0) {
            $this->text .= PHP_EOL;
            foreach ($map->include as $include) {
                $this->text .= self::getTextString('INCLUDE', $include, $indentSize + 1, $indent);
            }
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # MAP'.PHP_EOL;
    }
}
