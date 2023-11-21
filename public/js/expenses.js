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


//hide add expense div
$('#cancel').click(function () {
  $("#addExpensesDiv").toggle();
  $("#addExpensesFormDiv").toggle();
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
        }else{

        }
      },
      error: function(xhr, status, error) {
          console.error(xhr.responseText);
      }
  });
});

// AJAX request on year change
function selectOption(value) {
    $('.dropdown-item').removeClass('bg-primary'); // Remove bg-primary class from all items
    $(this).addClass('bg-primary');
    document.getElementById('yearDropdownButton').innerText = value;

    $.ajax({
        url: getExpenseData, // Route to fetch data from Laravel
        method: 'GET',
        data: { year: value },
        success: function(response) {
            console.log(response);
            $('.expense-table').html(response.table);

            var newData = {
                labels: response.month,
                datasets: [{
                    label: 'Monthly Expenses',
                    data: response.amount,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Bar color
                    borderColor: 'rgba(54, 162, 235, 1)', // Border color
                    borderWidth: 1
                }]
            };
            expensesChart.data.datasets[0].data = newData;

            //Redraw the chart
            expensesChart.update();
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function chartData(month,amount){

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

  // Get the context of the canvas element
  var ctx = document.getElementById('expenseChart').getContext('2d');

  // Create a bar chart
  var expensesChart = new Chart(ctx, {
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
}




