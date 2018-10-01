<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Map extends Writer
{
    public function write($map, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
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
        $this->text .= self::getTextRaw('MAXSIZE', $map->maxsize, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $map->name, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('RESOLUTION', $map->resolution, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('SCALEDENOM', $map->scaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('SHAPEPATH', $map->shapepath, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('SIZE', $map->size, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STATUS', $map->status, $indentSize + 1, $indent);
        $this->text .= self::getTextString('SYMBOLSET', $map->symbolset, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TEMPLATEPATTERN', $map->templatepattern, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('UNITS', $map->units, $indentSize + 1, $indent);

        if (!is_null($map->legend)) {
            $this->text .= PHP_EOL;
            $this->text .= (new Legend())->write($map->legend, $indentSize + 1, $indent);
        }

        if (!is_null($map->outputformat)) {
            $this->text .= PHP_EOL;
            $this->text .= (new OutputFormat())->write($map->outputformat, $indentSize + 1, $indent);
        }

        if (!is_null($map->projection)) {
            $this->text .= PHP_EOL;
            $this->text .= (new Projection())->write($map->projection, $indentSize + 1, $indent);
        }

        if (!is_null($map->querymap)) {
            $this->text .= PHP_EOL;
            $this->text .= (new QueryMap())->write($map->querymap, $indentSize + 1, $indent);
        }

        if (!is_null($map->reference)) {
            $this->text .= PHP_EOL;
            $this->text .= (new Reference())->write($map->reference, $indentSize + 1, $indent);
        }

        if (!is_null($map->scalebar)) {
            $this->text .= PHP_EOL;
            $this->text .= (new Scalebar())->write($map->scalebar, $indentSize + 1, $indent);
        }

        if (!is_null($map->web)) {
            $this->text .= PHP_EOL;
            $this->text .= (new Web())->write($map->web, $indentSize + 1, $indent);
        }

        foreach ($map->symbol as $symbol) {
            $this->text .= PHP_EOL;
            $this->text .= (new Symbol())->write($symbol, $indentSize + 1, $indent);
        }

        foreach ($map->layer as $layer) {
            $this->text .= PHP_EOL;
            $this->text .= (new Layer())->write($layer, $indentSize + 1, $indent);
        }

        $this->text .= PHP_EOL;
        foreach ($map->include as $include) {
            $this->text .= self::getTextString('INCLUDE', $include, $indentSize + 1, $indent);
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # MAP'.PHP_EOL;

        return $this->text;
    }
}
