<?php

use PHPUnit\Framework\TestCase;
use Shimoning\Period\Monthly;
use Carbon\Carbon;

class MonthlyTest extends TestCase
{
    public function test20200420()
    {
        // normally
        $period = Monthly::period(2020, 4, 20);

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(21, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(20, $period['end']->day);
    }

    public function test20200531()
    {
        // has 31th
        $period = Monthly::period(2020, 5, 31);

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(5, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(5, $period['end']->month);
        $this->assertEquals(31, $period['end']->day);
    }

    public function test20200431()
    {
        // has not 31th
        $period = Monthly::period(2020, 4, 31);

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(4, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(30, $period['end']->day);   // 31 -> 30
    }

    public function test20190231()
    {
        // 28th
        $period = Monthly::period(2019, 2, 31);

        $this->assertEquals(2019, $period['start']->year);
        $this->assertEquals(2, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2019, $period['end']->year);
        $this->assertEquals(2, $period['end']->month);
        $this->assertEquals(28, $period['end']->day);   // no leaping!
    }

    public function test20200231()
    {
        // 29th
        $period = Monthly::period(2020, 2, 31);

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(2, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(2, $period['end']->month);
        $this->assertEquals(29, $period['end']->day);   // leaping!
    }

    public function test20200401()
    {
        // closing 1st?
        $period = Monthly::period(2020, 4, 1);  // crazy

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(2, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(1, $period['end']->day);
    }

    public function test_weeklyBased_sunday()
    {
        $based = 0; // 日曜日基準

        // target -1 month
        $period2 = Monthly::weeklyBased(
            Carbon::create(2020, 3, 1),     // 日
            Carbon::create(2020, 3, 31),    // 火
            $based,
        );

        $this->assertEquals(2020, $period2['start']->year);
        $this->assertEquals(3, $period2['start']->month);
        $this->assertEquals(1, $period2['start']->day);

        $this->assertEquals(2020, $period2['end']->year);
        $this->assertEquals(3, $period2['end']->month);
        $this->assertEquals(28, $period2['end']->day);

        // target
        $period = Monthly::weeklyBased(
            Carbon::create(2020, 4, 1),     // 水
            Carbon::create(2020, 4, 30),    // 木
            $based
        );

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(29, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(25, $period['end']->day);

        // target +1 month
        $period3 = Monthly::weeklyBased(
            Carbon::create(2020, 5, 1),     // 金
            Carbon::create(2020, 5, 31),    // 日
            $based,
        );

        $this->assertEquals(2020, $period3['start']->year);
        $this->assertEquals(4, $period3['start']->month);
        $this->assertEquals(26, $period3['start']->day);

        $this->assertEquals(2020, $period3['end']->year);
        $this->assertEquals(5, $period3['end']->month);
        $this->assertEquals(30, $period3['end']->day);
    }

    public function test_weeklyBased_monday()
    {
        $based = 1; // 月曜日基準

        // target -1 month
        $period2 = Monthly::weeklyBased(
            Carbon::create(2020, 3, 1),     // 日
            Carbon::create(2020, 3, 31),    // 火
            $based,
        );

        $this->assertEquals(2020, $period2['start']->year);
        $this->assertEquals(2, $period2['start']->month);
        $this->assertEquals(24, $period2['start']->day);

        $this->assertEquals(2020, $period2['end']->year);
        $this->assertEquals(3, $period2['end']->month);
        $this->assertEquals(29, $period2['end']->day);

        // target
        $period = Monthly::weeklyBased(
            Carbon::create(2020, 4, 1),     // 水
            Carbon::create(2020, 4, 30),    // 木
            $based
        );

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(30, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(26, $period['end']->day);

        // target +1 month
        $period3 = Monthly::weeklyBased(
            Carbon::create(2020, 5, 1),     // 金
            Carbon::create(2020, 5, 31),    // 日
            $based,
        );

        $this->assertEquals(2020, $period3['start']->year);
        $this->assertEquals(4, $period3['start']->month);
        $this->assertEquals(27, $period3['start']->day);

        $this->assertEquals(2020, $period3['end']->year);
        $this->assertEquals(5, $period3['end']->month);
        $this->assertEquals(31, $period3['end']->day);
    }

    public function test_weeklyBased_tuesday()
    {
        $based = 2; // 火曜日基準

        // target -1 month
        $period2 = Monthly::weeklyBased(
            Carbon::create(2020, 3, 1),     // 日
            Carbon::create(2020, 3, 31),    // 火
            $based,
        );

        $this->assertEquals(2020, $period2['start']->year);
        $this->assertEquals(2, $period2['start']->month);
        $this->assertEquals(25, $period2['start']->day);

        $this->assertEquals(2020, $period2['end']->year);
        $this->assertEquals(3, $period2['end']->month);
        $this->assertEquals(30, $period2['end']->day);

        // target
        $period = Monthly::weeklyBased(
            Carbon::create(2020, 4, 1),     // 水
            Carbon::create(2020, 4, 30),    // 木
            $based
        );

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(31, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(27, $period['end']->day);

        // target +1 month
        $period3 = Monthly::weeklyBased(
            Carbon::create(2020, 5, 1),     // 金
            Carbon::create(2020, 5, 31),    // 日
            $based,
        );

        $this->assertEquals(2020, $period3['start']->year);
        $this->assertEquals(4, $period3['start']->month);
        $this->assertEquals(28, $period3['start']->day);

        $this->assertEquals(2020, $period3['end']->year);
        $this->assertEquals(5, $period3['end']->month);
        $this->assertEquals(25, $period3['end']->day);
    }

    public function test_weeklyBased_wednesday()
    {
        $based = 3; // 水曜日基準

        // target -1 month
        $period2 = Monthly::weeklyBased(
            Carbon::create(2020, 3, 1),     // 日
            Carbon::create(2020, 3, 31),    // 火
            $based,
        );

        $this->assertEquals(2020, $period2['start']->year);
        $this->assertEquals(2, $period2['start']->month);
        $this->assertEquals(26, $period2['start']->day);

        $this->assertEquals(2020, $period2['end']->year);
        $this->assertEquals(3, $period2['end']->month);
        $this->assertEquals(31, $period2['end']->day);

        // target
        $period = Monthly::weeklyBased(
            Carbon::create(2020, 4, 1),     // 水
            Carbon::create(2020, 4, 30),    // 木
            $based,
        );

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(4, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(28, $period['end']->day);

        // target +1 month
        $period3 = Monthly::weeklyBased(
            Carbon::create(2020, 5, 1),     // 金
            Carbon::create(2020, 5, 31),    // 日
            $based,
        );

        $this->assertEquals(2020, $period3['start']->year);
        $this->assertEquals(4, $period3['start']->month);
        $this->assertEquals(29, $period3['start']->day);

        $this->assertEquals(2020, $period3['end']->year);
        $this->assertEquals(5, $period3['end']->month);
        $this->assertEquals(26, $period3['end']->day);
    }

    public function test_weeklyBased_thursday()
    {
        $based = 4; // 木曜日基準

        // target -1 month
        $period2 = Monthly::weeklyBased(
            Carbon::create(2020, 3, 1),     // 日
            Carbon::create(2020, 3, 31),    // 火
            $based,
        );

        $this->assertEquals(2020, $period2['start']->year);
        $this->assertEquals(2, $period2['start']->month);
        $this->assertEquals(27, $period2['start']->day);

        $this->assertEquals(2020, $period2['end']->year);
        $this->assertEquals(3, $period2['end']->month);
        $this->assertEquals(25, $period2['end']->day);

        // target
        $period = Monthly::weeklyBased(
            Carbon::create(2020, 4, 1),     // 水
            Carbon::create(2020, 4, 30),    // 木
            $based
        );

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(26, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(29, $period['end']->day);

        // target +1 month
        $period3 = Monthly::weeklyBased(
            Carbon::create(2020, 5, 1),     // 金
            Carbon::create(2020, 5, 31),    // 日
            $based,
        );

        $this->assertEquals(2020, $period3['start']->year);
        $this->assertEquals(4, $period3['start']->month);
        $this->assertEquals(30, $period3['start']->day);

        $this->assertEquals(2020, $period3['end']->year);
        $this->assertEquals(5, $period3['end']->month);
        $this->assertEquals(27, $period3['end']->day);
    }

    public function test_weeklyBased_friday()
    {
        $based = 5; // 金曜日基準

        // target -1 month
        $period2 = Monthly::weeklyBased(
            Carbon::create(2020, 3, 1),     // 日
            Carbon::create(2020, 3, 31),    // 火
            $based,
        );

        $this->assertEquals(2020, $period2['start']->year);
        $this->assertEquals(2, $period2['start']->month);
        $this->assertEquals(28, $period2['start']->day);

        $this->assertEquals(2020, $period2['end']->year);
        $this->assertEquals(3, $period2['end']->month);
        $this->assertEquals(26, $period2['end']->day);

        // target
        $period = Monthly::weeklyBased(
            Carbon::create(2020, 4, 1),     // 水
            Carbon::create(2020, 4, 30),    // 木
            $based
        );

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(27, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(30, $period['end']->day);

        // target +1 month
        $period3 = Monthly::weeklyBased(
            Carbon::create(2020, 5, 1),     // 金
            Carbon::create(2020, 5, 31),    // 日
            $based,
        );

        $this->assertEquals(2020, $period3['start']->year);
        $this->assertEquals(5, $period3['start']->month);
        $this->assertEquals(1, $period3['start']->day);

        $this->assertEquals(2020, $period3['end']->year);
        $this->assertEquals(5, $period3['end']->month);
        $this->assertEquals(28, $period3['end']->day);
    }

    public function test_weeklyBased_saturday()
    {
        $based = 6; // 土曜日基準

        // target -1 month
        $period2 = Monthly::weeklyBased(
            Carbon::create(2020, 3, 1),     // 日
            Carbon::create(2020, 3, 31),    // 火
            $based,
        );

        $this->assertEquals(2020, $period2['start']->year);
        $this->assertEquals(2, $period2['start']->month);
        $this->assertEquals(29, $period2['start']->day);

        $this->assertEquals(2020, $period2['end']->year);
        $this->assertEquals(3, $period2['end']->month);
        $this->assertEquals(27, $period2['end']->day);

        // target
        $period = Monthly::weeklyBased(
            Carbon::create(2020, 4, 1),     // 水
            Carbon::create(2020, 4, 30),    // 木
            $based
        );

        $this->assertEquals(2020, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(28, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(24, $period['end']->day);

        // target +1 month
        $period3 = Monthly::weeklyBased(
            Carbon::create(2020, 5, 1),     // 金
            Carbon::create(2020, 5, 31),    // 日
            $based,
        );

        $this->assertEquals(2020, $period3['start']->year);
        $this->assertEquals(4, $period3['start']->month);
        $this->assertEquals(25, $period3['start']->day);

        $this->assertEquals(2020, $period3['end']->year);
        $this->assertEquals(5, $period3['end']->month);
        $this->assertEquals(29, $period3['end']->day);
    }

    public function test_weeklyBased_1st_sunday()
    {
        $based = 0; // 日曜日基準

        $period = Monthly::weeklyBased(
            Carbon::create(2024, 9, 1),     // 日
            Carbon::create(2024, 9, 30),    // 月
            $based
        );

        $this->assertEquals(2024, $period['start']->year);
        $this->assertEquals(9, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2024, $period['end']->year);
        $this->assertEquals(9, $period['end']->month);
        $this->assertEquals(28, $period['end']->day);
    }
}
