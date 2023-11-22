//show add expense div
$('#addExpensesDiv').click(function () {
  $("#addExpensesDiv").toggle();
  $("#addExpensesFormDiv").toggle();
});

//show import expense div
$('#importExpensesDiv').click(function () {
  $("#importExpensesDiv").toggle();
  $("#importExpensesFormDiv").toggle();
});

//show edit expense div
$(document).on('click', '.editExpense', function(event) {
  $("#editExpensesFormDiv"+$(this).data('id')).toggle();
});

//hide add expense div
$('#cancel').click(function () {
  $("#addExpensesDiv").toggle();
  $("#addExpensesFormDiv").toggle();
});

// AJAX request on year change
function selectOption(value) {
    $('.dropdown-item').removeClass('bg-primary'); // Remove bg-primary class from all items
    $(this).addClass('bg-primary');
    document.getElementById('yearDropdownButton').innerText = value;
    getData(value); //get data using ajax
}

//get data in year filter dropdown change
function getData(value){
  $.ajax({
    url: getExpenseData, // Route to fetch data from Laravel
    method: 'GET',
    data: { year: value },
    success: function(response) {
        $('.expense-table').html(response.table);
        chartData(response.month,response.amount);
    },
    error: function(error) {
        console.log(error);
    }
});
}
function chartData(month,amount){

  if (expensesChart) {
    expensesChart.destroy(); // Destroy the existing chart instance
  }

  var expensesData = {
    labels: month,
    datasets: [{
        label: 'Monthly Expenses',
        data: amount,
        backgroundColor: 'rgba(54, 162, 235, 0.5)', // Bar color
        borderColor: 'rgba(54, 162, 235, 1)', // Border color
        borderWidth: 1
    }]
  };

  expensesChart = new Chart(ctx, {
    type: 'bar',
    data: expensesData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
  });
  
  expensesChart.update(); 
}

window.Parsley.addValidator('csvfile', {
  validateString: function (value) {
      // Check if the file input has a value
      if (value) {
          // Get the file extension
          var extension = value.split('.').pop().toLowerCase();
          // Check if the file extension is 'csv'
          return extension === 'csv';
      }
      return false; // No file selected
  },
  messages: {
      en: 'Please select a CSV file.'
  }
});

//submit expense form
$('#addExpense').click(function(e) {
  e.preventDefault();        
  // Get form data
  var formData = $('#expenseForm').serialize();

  $.ajax({
      url: expenseDivRoute,
      method: 'POST',
      headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      data: formData,
      success: function(response) {
        if(response.success == true){
          // console.log(response);
          $('#expenseForm')[0].reset();
          $("#addExpensesDiv").toggle();
          $("#addExpensesFormDiv").toggle();

          getData(response.value); //get data using ajax
        }else{

        }
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        // Handle error response
        var errors = xhr.responseJSON;

        // Display error messages
        $.each(errors.errors, function (key, value) {
          console.log(key, value[0]);
            $('.' + key).html(value[0]).addClass('text-danger');
        });
      }
  });
});

$('#editExpense').click(function(e) {
  e.preventDefault();   
  
  var id = $(this).data('id');
  // Get form data
  var formData = $('#editExpenseForm'+id).serialize();

  $.ajax({
      url: editExpenseRoute.replace(':expenseId', id),
      method: 'POST',
      headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      data: formData,
      success: function(response) {
        if(response.success == true){
          // console.log(response);
          $('#editExpenseForm'+id)[0].reset();
          $("#editExpensesFormDiv"+id).toggle();

          getData(value); //get data using ajax
        }else{

        }
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        // Handle error response
        var errors = xhr.responseJSON;

        // Display error messages
        $.each(errors.errors, function (key, value) {
          console.log(key, value[0]);
            $('.' + key).html(value[0]).addClass('text-danger');
        });
      }
  });
});