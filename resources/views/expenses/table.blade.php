@foreach($expenses as $expense)
  <div class="d-flex border rounded border-secondary m-1 justify-content-center align-items-center bg-secondary">
    <div class="flex-column border rounded text-center m-3 p-3 bg-dark text-white">
      <h6 class="font-weight-bold">{{date('F',strtotime($expense->date))}}</h6>
      <h5>{{date('d',strtotime($expense->date))}}</h5>
      <h6>{{date('Y',strtotime($expense->date))}}</h6>
    </div>
    <div class="flex-column m-3 text-white" style="flex-basis: 60%;">
        <h4 class="font-weight-bold py-5">{{$expense->title}}</h4>
    </div>
    <div class="flex-column border rounded m-3 p-2 bg-primary text-white" style="height: 50px;">
      <h5 class="text-center">$ {{$expense->amount}}</h5>
    </div>
    <div class="flex-column m-3 p-1 text-white" style="height: 50px;">
      <a href="" class="btn btn-warning">Edit</a>
    </div>
    <div class="flex-column m-3 p-1 text-white" style="height: 50px;">
      <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit"  class="btn btn-danger">Delete</button>
    </form>
    </div>
  </div>
@endforeach