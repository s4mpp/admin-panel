<?php

namespace S4mpp\AdminPanel\Tests\Unit\Labels;

use Illuminate\View\View;
use Illuminate\Support\Carbon;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Labels\Datetime;

final class DatetimeTest extends TestCase
{
    public static function dateFormattedProvider()
    {
        return [
            'carbon' => [new Carbon('2024-01-12 13:45:23'), '12/01/2024 13:45:23'],
            'null' => [null, null],
        ];
    }

    public static function dateDiffForHumansProvider()
    {
        return [
            'carbon' => [new Carbon('2024-01-12 13:45:23'), '2 months ago'],
            'null' => [null, null],
        ];
    }

    /**
     * @dataProvider dateFormattedProvider
     */
    public function test_get_datetime_format(Carbon $input = null, string $date_formatted_expected = null): void
    {
        $label = new Datetime('Title', 'field', 'd/m/Y H:i:s');

        $datetime_formatted = $label->getDatetimeFormatted($input);

        $this->assertSame($date_formatted_expected, $datetime_formatted);
    }

    /**
     * @dataProvider dateDiffForHumansProvider
     */
    public function test_get_diff_for_humans(Carbon $input = null, string $diff_for_humans_expected = null): void
    {
        $label = new Datetime('Title', 'field', 'd/m/Y H:i:s');

        $diff_for_humans_result = $label->getDiffForHumans($input);

        $this->assertSame($diff_for_humans_expected, $diff_for_humans_result);
    }
}
