<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ExpenseHelper
{
    public static function getMonthlyExpenses($year)
    {
        $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $amount = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        $data = auth()->user()->expenses()
            ->whereYear('date', $year)
            ->select(DB::raw('MONTHNAME(date) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        foreach ($month as $index => $monthName) {
            if (array_key_exists($monthName, $data)) {
                $amount[$index] = $data[$monthName];
            }
        }

      return [
          'months' => $month,
          'amounts' => $amount,
      ];

    }
}
