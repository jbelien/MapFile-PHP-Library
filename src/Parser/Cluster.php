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
use MapFile\Model\Cluster as ClusterObject;

class Cluster extends Parser
{
    public function parse($content = null): ClusterObject
    {
        if (!is_null($content) && is_array($content)) {
            $this->content = $content;
        }

        $cluster = new ClusterObject();

        while ($this->eof === false) {
            $line = $this->getCurrentLine();
            if (strlen($line) === 0) {
                continue;
            }

            if (preg_match('/^CLUSTER$/i', $line) !== false) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'CLUSTER';
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^BUFFER ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) !== false) {
                $cluster->buffer = floatval($matches[1]);
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^FILTER ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $cluster->filter = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^FILTER (\(.+\))$/i', $line, $matches) !== false) {
                $cluster->filter = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^GROUP ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $cluster->group = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^GROUP (\(.+\))$/i', $line, $matches) !== false) {
                $cluster->group = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^MAXDISTANCE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches) !== false) {
                $cluster->maxdistance = floatval($matches[1]);
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^REGION ["\'](.+)["\']$/i', $line, $matches) !== false) {
                $cluster->region = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^END( # CLUSTER)?$/i', $line) !== false) {
                $this->lineEnd = $this->currentLineIndex;
                $this->parsing = null;

                break;
            } else {
                throw new UnsupportedException(
                    sprintf('Unsupported (or deprecated) parameter "%s" at line %d.', $line, $this->currentLineIndex)
                );
            }
        }

        return $cluster;
    }
}
