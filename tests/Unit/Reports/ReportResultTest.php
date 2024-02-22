<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use App\Models\User;
use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Reports\ReportResult;

final class ReportResultTest extends TestCase
{
    public function test_create_instance(): void
    {
        $report_result = new ReportResult('Report example', User::class, 'getUsers');

        $this->assertSame(User::class, $report_result->getModel());
        $this->assertSame('getUsers', $report_result->getMethod());

        $this->assertIsArray($report_result->getColumns());
        $this->assertEmpty($report_result->getColumns());
    }

    public function test_add_column(): void
    {
        $report_result = new ReportResult('Report example', User::class, 'getUsers');

        $add_column = $report_result->addColumn(new Text('Title', 'title'));

        $this->assertInstanceOf(ReportResult::class, $add_column);

        $this->assertCount(1, $report_result->getColumns());
    }
}
