<?php

declare(strict_types=1);

namespace Tests\Write;

use MapFile\Model\Join as JoinObject;
use MapFile\Writer\Join;
use Tests\WriteTest;

final class JoinTest extends WriteTest
{
    protected string $path = 'tests/.temp/JOIN.test';
    protected string $stub = 'tests/stubs/JOIN';

    public function test(): void
    {
        $join = new JoinObject();
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

        $writer = new Join($this->path);
        $writer->write($join);
        $result = $writer->save();

        $this->assertTrue($result);
        $this->assertFileEquals($this->stub, $this->path);
    }
}