<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use App\Models\User;
use S4mpp\Laraguard\Utils;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Factories\Filter;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Factories\CustomAction as CustomActionFactory;

class ReportTest extends TestCase
{
	public function test_create_instance()
	{
		$report = new Report('Report example', []);

		$this->assertSame('report-example', $report->getSlug());
		$this->assertSame('Report example', $report->getTitle());

		$this->assertIsArray($report->getFields());
		$this->assertEmpty($report->getFields());

		$this->assertIsArray($report->getPossibleResults());
		$this->assertEmpty($report->getPossibleResults());
	}

	public function test_add_result()
	{
		$report = new Report('Report example', []);

		$report->result('Report example', User::class, 'getUsers', [new Text('Title', 'title')]);

		$this->assertCount(1, $report->getPossibleResults());
	}
	
}