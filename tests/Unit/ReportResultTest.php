<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use App\Models\User;
use S4mpp\Laraguard\Utils;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Factories\Filter;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Factories\CustomAction as CustomActionFactory;
use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Reports\ReportResult;

class ReportResultTest extends TestCase
{
	public function test_create_instance()
	{
		$report_result = new ReportResult('Report example', User::class, 'getUsers');

		$this->assertSame(User::class, $report_result->getModel());
		$this->assertSame('getUsers', $report_result->getMethod());

		$this->assertIsArray($report_result->getColumns());
		$this->assertEmpty($report_result->getColumns());
	}

	public function test_add_column()
	{
		$report_result = new ReportResult('Report example', User::class, 'getUsers');

		$add_column = $report_result->addColumn(new Text('Title', 'title'));

		$this->assertInstanceOf(ReportResult::class, $add_column);

		$this->assertCount(1, $report_result->getColumns());
	}
}