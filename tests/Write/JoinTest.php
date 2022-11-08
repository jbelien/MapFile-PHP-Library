<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Join;
use MapFile\Writer\Join as Writer;
use Tests\WriteTest;

final class JoinTest extends WriteTest
{
    public function test(): void
    {
        $join = new Join();
        $join->connection = 'server:user:password:database';
        $join->connectiontype = 'MYSQL';
        $join->footer = 'footer.html';
        $join->from = 'ID';
        $join->header = 'header.html';
        $join->name = 'mysql-join';
        $join->table = 'mysql-tablename';
        $join->template = 'template.html';
        $join->to = 'mysql-column';
        $join->type = 'ONE-TO-ONE';

        $result = (new Writer($join))->save($this->path);

        self::assertTrue($result);
        self::assertFileEquals($this->stub, $this->path);
    }
}
