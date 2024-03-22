<?php

namespace S4mpp\AdminPanel\Tests\Unit\Filters;

use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;
use Workbench\App\Models\User;

final class PeriodTest extends TestCase
{
    public static function filterPeriodProvider(): array
    {
        return [
            'start and end (same date)' => [['start' => '2023-01-01', 'end' => '2023-01-01'], '01/01/2023 a 01/01/2023'],
            'only start' => [['start' => '2023-02-15'], 'a partir de 15/02/2023'],
            'only end' => [['end' => '2024-03-02'], 'até 02/03/2024']
        ];
    }

    public function test_create_period()
    {
        $period = new Period('Date', 'created_at');

        $this->assertSame('Date', $period->getTitle());
        $this->assertSame('created_at', $period->getField());
        $this->assertSame('{start: null, end: null}', $period->getAlpineExpression());
    }

    public function test_query()
    {
        $period = new Period('Date', 'created_at');

        $query = User::select('created_at');

        $query->where($period->query($query, ['start' => '2023-01-01', 'end' => '2023-01-01']));

        $total_found = $query->count();
        
        $this->assertEquals(0, $total_found);
    }

    /**
     * @dataProvider filterPeriodProvider
     */
    public function test_get_description_result(array $filter, string $description_expected): void
    {
        $period = new Period('Date', 'created_at');

        $description_test = $period->getDescriptionResult($filter);

        $this->assertSame($description_expected, $description_test);
    }
}
