<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

class Layer extends Writer
{
    public function write($layer, int $indentSize = 0, string $indent = self::WRITER_INDENT): string
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'LAYER'.PHP_EOL;

        $this->text .= self::getTextString('CLASSGROUP', $layer->classgroup, $indentSize + 1, $indent);
        $this->text .= self::getTextString('CLASSITEM', $layer->classitem, $indentSize + 1, $indent);

        if (!is_null($layer->cluster)) {
            $this->text .= (new Cluster())->write($layer->cluster, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextString('CONNECTION', $layer->connection, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('CONNECTIONTYPE', $layer->connectiontype, $indentSize + 1, $indent);
        $this->text .= self::getTextString('DATA', $layer->data, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('DEBUG', $layer->debug, $indentSize + 1, $indent);
        $this->text .= self::getTextString('ENCODING', $layer->encoding, $indentSize + 1, $indent);
        $this->text .= self::getTextArray('EXTENT', $layer->extent, $indentSize + 1, $indent);
        $this->text .= self::getText('FILTER', $layer->filter, $indentSize + 1, $indent);
        $this->text .= self::getTextString('FILTERITEM', $layer->filteritem, $indentSize + 1, $indent);
        $this->text .= self::getTextString('FOOTER', $layer->footer, $indentSize + 1, $indent);
        $this->text .= self::getText('GEOMTRANSFORM', $layer->geomtransform, $indentSize + 1, $indent);

        if (!is_null($layer->grid)) {
            $this->text .= (new Grid())->write($layer->grid, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextString('GROUP', $layer->group, $indentSize + 1, $indent);
        $this->text .= self::getTextString('HEADER', $layer->header, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('LABELCACHE', $layer->labelcache, $indentSize + 1, $indent);
        $this->text .= self::getTextString('LABELITEM', $layer->labelitem, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('LABELMAXSCALEDENOM', $layer->labelmaxscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('LABELMINSCALEDENOM', $layer->labelminscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('LABELREQUIRES', $layer->labelrequires, $indentSize + 1, $indent);
        $this->text .= self::getTextString('MASK', $layer->mask, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXFEATURES', $layer->maxfeatures, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXGEOWIDTH', $layer->maxgeowidth, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXSCALEDENOM', $layer->maxscaledenom, $indentSize + 1, $indent);

        if (!empty($layer->metadata)) {
            $this->text .= (new Metadata())->write($layer->metadata, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextRaw('MINGEOWIDTH', $layer->mingeowidth, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MINSCALEDENOM', $layer->minscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('NAME', $layer->name, $indentSize + 1, $indent);
        $this->text .= is_array($layer->offsite) ? self::getTextArray('OFFSITE', $layer->offsite, $indentSize + 1, $indent) : self::getTextString('OFFSITE', $layer->offsite, $indentSize + 1, $indent);
        $this->text .= self::getText('OPACITY', $layer->opacity, $indentSize + 1, $indent);
        $this->text .= self::getTextString('PLUGIN', $layer->plugin, $indentSize + 1, $indent);
        $this->text .= self::getTextBoolean('POSTLABELCACHE', $layer->postlabelcache, $indentSize + 1, $indent);

        foreach ($layer->processing as $processing) {
            $this->text .= self::getTextString('PROCESSING', $processing, $indentSize + 1, $indent);
        }

        if (!is_null($layer->projection)) {
            $this->text .= (new Projection())->write($layer->projection, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextString('REQUIRES', $layer->requires, $indentSize + 1, $indent);

        if (!is_null($layer->scaletoken)) {
            $this->text .= (new ScaleToken())->write($layer->scaletoken, $indentSize + 1, $indent);
        }

        $this->text .= self::getTextRaw('SIZEUNITS', $layer->sizeunits, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('STATUS', $layer->status, $indentSize + 1, $indent);
        $this->text .= self::getTextString('STYLEITEM', $layer->styleitem, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('SYMBOLSCALEDENOM', $layer->symbolscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TEMPLATE', $layer->template, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TILEINDEX', $layer->tileindex, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TILEITEM', $layer->tileitem, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TILESRS', $layer->tilesrs, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TOLERANCE', $layer->tolerance, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TOLERANCEUNITS', $layer->toleranceunits, $indentSize + 1, $indent);
        $this->text .= is_bool($layer->transform) ? self::getTextBoolean('TRANSFORM', $layer->transform, $indentSize + 1, $indent) : self::getTextRaw('TRANSFORM', $layer->transform, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('TYPE', $layer->type, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('UNITS', $layer->units, $indentSize + 1, $indent);
        $this->text .= self::getTextString('UTFDATA', $layer->utfdata, $indentSize + 1, $indent);
        $this->text .= self::getTextString('UTFITEM', $layer->utfitem, $indentSize + 1, $indent);

        if (!is_null($layer->validation)) {
            $this->text .= (new Validation())->write($layer->validation, $indentSize + 1, $indent);
        }

        foreach ($layer->class as $class) {
            $this->text .= PHP_EOL;
            $this->text .= (new LayerClass())->write($class, $indentSize + 1, $indent);
        }

        foreach ($layer->composite as $composite) {
            $this->text .= PHP_EOL;
            $this->text .= (new Composite())->write($composite, $indentSize + 1, $indent);
        }

        foreach ($layer->feature as $feature) {
            $this->text .= PHP_EOL;
            $this->text .= (new Feature())->write($feature, $indentSize + 1, $indent);
        }

        foreach ($layer->join as $join) {
            $this->text .= PHP_EOL;
            $this->text .= (new Join())->write($join, $indentSize + 1, $indent);
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # LAYER'.PHP_EOL;

        return $this->text;
    }
}
