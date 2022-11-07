<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class ParseTest extends TestCase
{
    protected string $stub;

    protected function setUp(): void
    {
        $this->stub = sprintf('tests/stubs/%s', strtoupper($this->getClass()));
    }

    protected function getClass(): string
    {
        $class = get_class($this);

        $pos = strrpos($class, '\\');

        $testClass = $pos !== false ? substr($class, $pos + 1) : $class;

        return str_replace('Test', '', $testClass);
    }
}
