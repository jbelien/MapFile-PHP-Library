<?php

declare(strict_types=1);

/**
 * MapFile Generator - MapServer .MAP Generator (Read, Write & Preview).
 *
 * @author Jonathan Beliën
 * @license GNU General Public License, version 2
 */

namespace MapFile\Writer;

use MapFile\Model\Web as WebObject;

class Web extends Writer
{
    public function __construct(WebObject $web, int $indentSize = 0, string $indent = self::WRITER_INDENT)
    {
        $this->text = str_repeat($indent, $indentSize);
        $this->text .= 'WEB'.PHP_EOL;

        $this->text .= self::getTextString('BROWSEFORMAT', $web->browseformat, $indentSize + 1, $indent);
        $this->text .= self::getTextString('EMPTY', $web->empty, $indentSize + 1, $indent);
        $this->text .= self::getTextString('ERROR', $web->error, $indentSize + 1, $indent);
        $this->text .= self::getTextString('FOOTER', $web->footer, $indentSize + 1, $indent);
        $this->text .= self::getTextString('HEADER', $web->header, $indentSize + 1, $indent);
        $this->text .= self::getTextString('IMAGEPATH', $web->imagepath, $indentSize + 1, $indent);
        $this->text .= self::getTextString('IMAGEURL', $web->imageurl, $indentSize + 1, $indent);
        $this->text .= self::getTextString('LEGENDFORMAT', $web->legendformat, $indentSize + 1, $indent);
        $this->text .= self::getTextRaw('MAXSCALEDENOM', $web->maxscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('MAXTEMPLATE', $web->maxtemplate, $indentSize + 1, $indent);

        if (count($web->metadata) > 0) {
            $this->text .= (new Metadata($web->metadata, $indentSize + 1, $indent))->text;
        }

        $this->text .= self::getTextRaw('MINSCALEDENOM', $web->minscaledenom, $indentSize + 1, $indent);
        $this->text .= self::getTextString('MINTEMPLATE', $web->mintemplate, $indentSize + 1, $indent);
        $this->text .= self::getTextString('QUERYFORMAT', $web->queryformat, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TEMPLATE', $web->template, $indentSize + 1, $indent);
        $this->text .= self::getTextString('TEMPPATH', $web->temppath, $indentSize + 1, $indent);

        if (!is_null($web->validation)) {
            $this->text .= (new Validation($web->validation, $indentSize + 1, $indent))->text;
        }

        $this->text .= str_repeat($indent, $indentSize);
        $this->text .= 'END # WEB'.PHP_EOL;
    }
}
