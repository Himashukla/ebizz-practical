<div class="card-body" id="addExpensesFormDiv" style="display: none">
    <form id="expenseForm" method="POST" method="POST" enctype="multipart/form-data"
        action="{{route('expenses.store')}}" data-parsley-validate>
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label class="font-weight-bold">Title</label>
                <input type="text" name="title" class="form-control" required data-parsley-trigger="change"
                    data-parsley-required-message="Please enter title">
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="font-weight-bold">Amount</label>
                <input type="number" name="amount" class="form-control" required data-parsley-trigger="change"
                    data-parsley-required-message="Please enter amount" data-parsley-pattern="^\d+$">
                @error('amount')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="font-weight-bold">Date</label>
                <input type="date" name="date" class="form-control" required data-parsley-trigger="change"
                    data-parsley-required-message="Please select date">
                @error('date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
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
                    <input type="submit" name="submit" value="Store Expense" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>
</div>