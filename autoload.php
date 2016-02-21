<?php
function MapFileAutoload($classname) {
  list($namespace, $class) = explode('\\', $classname);
  $filename = __DIR__.'/'.strtolower($class).'.php';
  if (is_readable($filename)) { require $filename; }
}

spl_autoload_register('MapFileAutoload', TRUE, TRUE);