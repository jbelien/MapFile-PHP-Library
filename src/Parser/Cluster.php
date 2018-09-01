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
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^CLUSTER$/i', $line)) {
                $this->lineStart = $this->currentLineIndex;
                $this->parsing = 'CLUSTER';
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^BUFFER ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $cluster->buffer = floatval($matches[1]);
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^FILTER ["\'](.+)["\']$/i', $line, $matches)) {
                $cluster->filter = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^FILTER (\(.+\))$/i', $line, $matches)) {
                $cluster->filter = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^GROUP ["\'](.+)["\']$/i', $line, $matches)) {
                $cluster->group = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^GROUP (\(.+\))$/i', $line, $matches)) {
                $cluster->group = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^MAXDISTANCE ([0-9]+(?:\.(?:[0-9]+))?)$/i', $line, $matches)) {
                $cluster->maxdistance = floatval($matches[1]);
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^REGION ["\'](.+)["\']$/i', $line, $matches)) {
                $cluster->region = $matches[1];
            } elseif ($this->parsing === 'CLUSTER' && preg_match('/^END( # CLUSTER)?$/i', $line)) {
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
