<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\ExpenseRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;
use Auth;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Helpers\ExpenseHelper;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->user()->expenses);
      //get all the years from expenses table to showcase in dropdown
      $years = $expenses = $data = [];
      
      if(auth()->user()->expenses()->count() > 0){
          $years = Expense::selectRaw('YEAR(date) as year')
              ->distinct()
              ->orderBy('year', 'DESC')
              ->pluck('year')
              ->toArray();

          $expenses = auth()->user()->expenses()->whereYear('date', $years[0])->get();

          $expensesData = ExpenseHelper::getMonthlyExpenses($years[0]);

          $month = $expensesData['months'];
          $amount = $expensesData['amounts'];          
      }
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
    public function store(ExpenseRequest $request)
    {
        $expense = Expense::create([
          'user_id' => auth()->user()->id,
          'title' => $request->title,
          'amount' => $request->amount,
          'date' => $request->date,
        ]);

        if($expense){
          return redirect()->back()->with('success', 'Expenses saved successfully!');
        } else {
            return redirect()->back()->with('error', 'There\'s some issue');
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
    public function update(ExpenseRequest $request, Expense $expense)
    {
            $expense->update([
                'title' => $request->title,
                'amount' => $request->amount,
                'date' => $request->date,
            ]);
  
          if($expense){
            return redirect()->back();
            //json(['success' => true,'message' => 'Form submitted successfully']);
          }else{
            return redirect()->back();
            //json(['success' => false,'message' => 'There\'s some issue']);
          }
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
        if($expense){
          return redirect()->back()->with('success', 'Expenses deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'There\'s some issue');
        }
    }

    public function getExpenses(Request $request){
      $expenses = auth()->user()->expenses()->whereYear('date', $request->year)->get();

      $expensesData = ExpenseHelper::getMonthlyExpenses($years[0]);

      $month = $expensesData['months'];
      $amount = $expensesData['amounts'];
      return response()->json(['success' => true,'table' => view('expenses.table',compact('expenses'))->render(),'chart' => view('expenses.chart')->render(),'month'=>$month,'amount'=>$amount]);
    }

    public function importExpensesFromCSV(ImportRequest $request)
    {
              
        $file = $request->file('file');
        $mime = $file->getMimeType();

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
                $expense->user_id = auth()->user()->id;
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