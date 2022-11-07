<?php

declare(strict_types=1);

namespace Tests;

abstract class WriteTest extends ParseTest
{
    protected string $path;

    protected function setUp(): void
    {
        parent::setUp();

        $this->path = sprintf('tests/.temp/%s.test', strtoupper($this->getClass()));

        touch($this->path);
    }

    protected function tearDown(): void
    {
        unlink($this->path);
    }
}
