<div class="card-body" id="addExpensesFormDiv" style="display: none">
  <form id="expenseForm" method="POST">
      <div class="row">
        <div class="col-md-6">
          <label class="font-weight-bold">Title</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="font-weight-bold">Amount</label>
          <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="font-weight-bold">Date</label>
          <input type="date" name="date" class="form-control" required>
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
            <button class="btn btn-primary" id="addExpense">Add Expense</button>
          </div>
        </div>
      </div>
  </form>
</div>