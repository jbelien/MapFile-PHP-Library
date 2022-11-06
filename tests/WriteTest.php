<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class WriteTest extends TestCase
{
    protected string $path;
    protected string $stub;

    protected function setUp(): void
    {
        touch($this->path);
    }

    protected function tearDown(): void
    {
        unlink($this->path);
    }
}
