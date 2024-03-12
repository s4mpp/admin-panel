<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use App\Models\User;
use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Elements\Report;

final class ReportTest extends TestCase
{
    public function test_create_instance(): void
    {
        $report = new Report('Report example', fn() => null, []);

        $this->assertSame('report-example', $report->getSlug());
        $this->assertSame('Report example', $report->getTitle());

    }
}
