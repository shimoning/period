<?php

namespace Shimoning\Period;

use Carbon\Carbon;

class Yearly
{
    /**
     * 締め日を指定して期間の開始日と終了日を取得する
     *
     * @param int $year
     * @param int $month
     * @param int $closingDay
     * @return [ Carbon, Carbon ]
     */
    static public function period(int $year, int $month, $closingDay = 31)
    {
        // 終了日の検定
        $thisMonthDate = Carbon::create($year, $month, 1);  // 当月
        echo $thisMonthDate->format('Y-m-d');
        $lastDayOfThisMonth = $thisMonthDate->lastOfMonth()->day;   // 当月の最終日
        $endDay = $closingDay > $lastDayOfThisMonth
            ? $lastDayOfThisMonth
            : $closingDay;

        // 開始日の検定
        $lastMonthDate = Carbon::create($year - 1, $month, 1);  // 今年度最終月
        $lastDayOfLastMonth = $lastMonthDate->lastOfMonth()->day;   // 今年度最終月の最終日
        $startDay = $closingDay > $lastDayOfLastMonth
            ? $lastDayOfLastMonth + 1
            : $closingDay + 1;

        return [
            'start' => Carbon::create($year - 1, $month, $startDay),
            'end' => Carbon::create($year, $month, $endDay),
        ];
    }
}
