<div class="card-body" id="importExpensesFormDiv" style="display: none">
    <form id="expenseForm" method="POST" method="POST" enctype="multipart/form-data"
        action="{{route('import.expenses')}}" data-parsley-validate>
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label class="font-weight-bold">Select File</label>
                <input type="file" name="file" class="form-control" required data-parsley-csvfile="true"
                    data-parsley-trigger="change" data-parsley-required-message="Please select file"
                    data-parsley-filetype-message="Please upload only CSV file">
                @error('file')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class=" row mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <!-- Blank div -->
                </div>
                <div>
                    <!-- Buttons -->
                    <button class="btn btn-secondary mr-2" id="cancel">Cancel</button>
                    <input type="submit" name="submit" value="Import File" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>
</div>