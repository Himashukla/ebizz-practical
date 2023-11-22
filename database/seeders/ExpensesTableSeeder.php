<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expense;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create sample expenses
        Expense::create([
            'user_id' => 1,
            'title' => 'Expense 1',
            'amount' => 500,
            'date' => date('2002-05-13'),
        ]);

        Expense::create([
            'user_id' => 2,
            'title' => 'Expense 2',
            'amount' => 150,
            'date' => date('2020-03-13'),
        ]);

        Expense::create([
            'user_id' => 3,
            'title' => 'Expense 3',
            'amount' => 550,
            'date' => date('2002-10-13'),
        ]);

        Expense::create([
            'user_id' => 1,
            'title' => 'Expense 4',
            'amount' => 190,
            'date' => date('2020-04-13'),
        ]);
    }
}