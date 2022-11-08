# MapFile-PHP-Library

[![Latest Stable Version](https://poser.pugx.org/jbelien/mapfile-php-library/v/stable)](https://packagist.org/packages/jbelien/mapfile-php-library)
[![Total Downloads](https://poser.pugx.org/jbelien/mapfile-php-library/downloads)](https://packagist.org/packages/jbelien/mapfile-php-library)
[![Monthly Downloads](https://poser.pugx.org/jbelien/mapfile-php-library/d/monthly.png)](https://packagist.org/packages/jbelien/mapfile-php-library)
[![Software License](https://img.shields.io/badge/license-GPL--2.0-brightgreen.svg)](LICENSE)

PHP Library to read/write MapServer mapfiles.

This library is based on [MapServer 7.2.0 documentation](https://mapserver.org/mapfile/) (last updated on 16 June 2017).

## Installation

```
composer require jbelien/mapfile-php-library:2.x-dev
```

## Usage

### Write MapFile (example)

```php
$map = new \MapFile\Model\Map();

$map->name = 'my-mapfile';
$map->projection = 'EPSG:4326';

$map->scalebar = new \MapFile\Model\Scalebar();
$map->scalebar->units = 'kilometers';

$layer = new \MapFile\Model\Layer();
$layer->name = 'my-layer';
$layer->type = 'POLYGON';
$layer->status = 'ON';
$layer->data = 'my-shapefile';
$layer->projection = 'EPSG:4326';

$class = new \MapFile\Model\LayerClass();

$style = new \MapFile\Model\Style();
$style->color = [0, 0, 0];
$class->style->add($style);

$label = new \MapFile\Model\Label();
$label->text = '[label]';
$label->color = [0, 0, 0];
$label->size = 12;
$class->label->add($label);

$layer->class->add($class);

$map->layer->add($layer);

$mapfile = (new \MapFile\Writer\Map($map))->save('my-mapfile.map');
```

Have a look at the [source code](https://github.com/jbelien/MapFile-PHP-Library/tree/master/src/Model) to see all the available options.

### Parse MapFile (example)

```php
$map = (new \MapFile\Parser\Map())->parse('my-mapfile.map');

foreach ($map->layer as $layer) {
    echo $layer->name;
}
```
