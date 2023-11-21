<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;
use Auth;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //get all the years from expenses table to showcase in dropdown
      $years = Expense::selectRaw('YEAR(date) as year')
              ->distinct()
              ->orderBy('year','DESC')
              ->pluck('year')
              ->toArray();
      $expenses = Expense::whereYear('date', $years[0])->get();

      $data = Expense::whereYear('date', $years[0])
            ->select(DB::raw('MONTHNAME(date) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->pluck('total','month')->toArray();
      $month = array_keys($data);
      $amount = array_values($data);
      return view('expenses.index',compact('years','expenses','month','amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense = Expense::create([
          'title' => $request->title,
          'amount' => $request->amount,
          'date' => $request->date,
        ]);

        if($expense){
          return response()->json(['success' => true,'message' => 'Form submitted successfully']);
        }else{
          return response()->json(['success' => false,'message' => 'There\'s some issue']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->back();
    }

    public function getExpenses(Request $request){
      $expenses = Expense::whereYear('date', $request->year)->get();

      $data = Expense::whereYear('date', $request->year)
            ->select(DB::raw('MONTHNAME(date) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->pluck('total','month')->toArray();
      $month = array_keys($data);
      $amount = array_values($data);
      return response()->json(['success' => true,'table' => view('expenses.table',compact('expenses'))->render(),'chart' => view('expenses.chart')->render(),'month'=>$month,'amount'=>$amount]);
    }

    public function importExpensesFromCSV(Request $request)
    {
        $file = $request->file('file'); // Assuming the CSV file is sent via form

        if ($file) {
            $reader = IOFactory::createReader('Csv');
            $reader->setDelimiter(',');
            $reader->setEnclosure('"');
            $spreadsheet = $reader->load($file->getPathname());

            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Process each row from the CSV
            foreach ($rows as $row) {
                // Assuming the CSV columns are in the order of title, amount, date
                $expense = new Expense();
                $expense->title = $row[0]; // Replace with the appropriate column index
                $expense->amount = $row[1]; // Replace with the appropriate column index
                $expense->date = date('Y-m-d',strtotime($row[2])); // Replace with the appropriate column index
                $expense->save();
            }

            return redirect()->back()->with('success', 'Expenses imported successfully!');
        } else {
            return redirect()->back()->with('error', 'Please select a CSV file.');
        }
    }
}
