<div class="card-body" id="importExpensesFormDiv" style="display: none">
  <form id="expenseForm" method="POST" method="POST" enctype="multipart/form-data" action="{{route('import.expenses')}}">
    @csrf
      <div class="row">
        <div class="col-md-6">
          <label class="font-weight-bold">Select File</label>
          <input type="file" name="file" class="form-control" required>
        </div>
      </div>
      <div class="row mt-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <!-- Blank div -->
          </div>
          <div>
            <!-- Buttons -->
            <button class="btn btn-secondary mr-2" id="cancel">Cancel</button>
            <button class="btn btn-primary" id="importExpense">Import File</button>
          </div>
        </div>
      </div>
  </form>
</div>