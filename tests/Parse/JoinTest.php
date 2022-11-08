<?php

declare(strict_types=1);

namespace Tests\Parse;

use MapFile\Parser\Join;
use Tests\ParseTest;

final class JoinTest extends ParseTest
{
    public function test(): void
    {
        $parser = new Join($this->stub);
        $join = $parser->parseBlock();

        self::assertSame('server:user:password:database', $join->connection);
        self::assertSame('MYSQL', $join->connectiontype);
        self::assertSame('footer.html', $join->footer);
        self::assertSame('ID', $join->from);
        self::assertSame('header.html', $join->header);
        self::assertSame('mysql-join', $join->name);
        self::assertSame('mysql-tablename', $join->table);
        self::assertSame('template.html', $join->template);
        self::assertSame('mysql-column', $join->to);
        self::assertSame('ONE-TO-ONE', $join->type);
    }
}
