<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\TestCase;

class ProjectModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_projects_table_has_expected_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('projects', [
                'id','title', 'description', 'status', 'start_date', 'end_date', 'project_id'
            ]), 1);
    }

}
