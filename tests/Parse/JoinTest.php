<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Join;
use PHPUnit\Framework\TestCase;

final class JoinTest extends TestCase
{
    protected string $stub = 'tests/stubs/JOIN';

    public function test(): void
    {
        $parser = new Join($this->stub);
        $join = $parser->parse();

        $this->assertSame('server:user:password:database', $join->connection);
        $this->assertSame('MYSQL', $join->connectiontype);
        $this->assertSame('footer.html', $join->footer);
        $this->assertSame('ID', $join->from);
        $this->assertSame('header.html', $join->header);
        $this->assertSame('mysql-join', $join->name);
        $this->assertSame('mysql-tablename', $join->table);
        $this->assertSame('template.html', $join->template);
        $this->assertSame('mysql-column', $join->to);
        $this->assertSame('ONE-TO-ONE', $join->type);
    }
}
