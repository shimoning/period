<?php
use PHPUnit\Framework\TestCase;
use Shimoning\Period\Yearly;

class YearlyTest extends TestCase
{
    public function test20200420()
    {
        // normally
        $period = Yearly::period(2020, 4, 20);

        $this->assertEquals(2019, $period['start']->year);
        $this->assertEquals(4, $period['start']->month);
        $this->assertEquals(21, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(20, $period['end']->day);
    }

    public function test20200531()
    {
        // has 31th
        $period = Yearly::period(2020, 5, 31);

        $this->assertEquals(2019, $period['start']->year);
        $this->assertEquals(6, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(5, $period['end']->month);
        $this->assertEquals(31, $period['end']->day);
    }

    public function test20200431()
    {
        // has not 31th
        $period = Yearly::period(2020, 4, 31);

        $this->assertEquals(2019, $period['start']->year);
        $this->assertEquals(5, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(30, $period['end']->day);   // 31 -> 30
    }

    public function test20190231()
    {
        // 28th
        $period = Yearly::period(2019, 2, 31);

        $this->assertEquals(2018, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2019, $period['end']->year);
        $this->assertEquals(2, $period['end']->month);
        $this->assertEquals(28, $period['end']->day);   // no leaping!
    }

    public function test20200231()
    {
        // 29th
        $period = Yearly::period(2020, 2, 31);

        $this->assertEquals(2019, $period['start']->year);
        $this->assertEquals(3, $period['start']->month);
        $this->assertEquals(1, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(2, $period['end']->month);
        $this->assertEquals(29, $period['end']->day);   // leaping!
    }

    public function test20200401()
    {
        // closing 1st?
        $period = Yearly::period(2020, 4, 1);  // about school

        $this->assertEquals(2019, $period['start']->year);
        $this->assertEquals(4, $period['start']->month);
        $this->assertEquals(2, $period['start']->day);

        $this->assertEquals(2020, $period['end']->year);
        $this->assertEquals(4, $period['end']->month);
        $this->assertEquals(1, $period['end']->day);
    }
}
