@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body text-center" id="addExpensesDiv">
         <a href="javascript:void(0);" class="btn btn-primary btn-lg">
          <i class="fa-solid fa-plus fa-xl"></i> Add New Expense</a>
        </div>
        @include('expenses.create')
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card p-3">
          <div class="row">
            <div class="col-md-6">
                <h5>Filter by year</h5> <!-- Title at Left -->
            </div>
            <div class="col-md-6 text-right">
                <!-- Dropdown at Right -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="yearDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$years[0]}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      @foreach($years as $year)
                        <a class="dropdown-item @if($loop->first) bg-primary @endif" href="javascript:void(0);" onclick="selectOption({{$year}})">{{$year}}</a>
                      @endforeach
                    </div>
                </div>
            </div>
          </div>
          
          <div class="expense-chart">
          @include('expenses.chart')
          </div>
          
          <div class="expense-table">
          @include('expenses.table')
          </div>
          
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body text-center" id="importExpensesDiv">
         <a href="javascript:void(0);" class="btn btn-primary btn-lg">
          <i class="fa-solid fa-plus fa-xl"></i> Import Expense</a>
        </div>
        @include('expenses.import')
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  var expenseDivRoute = '{{route("expenses.store")}}';
  var getExpenseData = '{{route("expenses.get.expense")}}';
  var expensesChart;
  $(function(){
    $('#expenseForm').parsley();
    chartData(@json($month),@json($amount));  
  });
</script>
@endsection