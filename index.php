<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>data tables</title>
</head>
<body>
    <form method="post">
        <table id="myTable">
            <div><buttton class="btn btn-primary" id="deleteBtn">delete</buttton></div>
        </table>
</form>

<script src="./plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="./plugins/CellEdit/js/dataTables.cellEdit.js"></script>
<!-- <script src="./plugins/toastr/toastr.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
//  toastr.success("HI");
$(document).ready(function (){
    var arr = [];
    var table = $("#myTable").DataTable({


   

        ajax:{
            type:"POST",
            url: "./backend/authcontroller.php",
            contentType:'application/json',
            dataSrc: '',
            dataType: 'json',
            // data:JSON.stringify({action:"select",'data':'hello'}),
            data: function () {
            return JSON.stringify({action:"select"});
},
        },
        order:[],
        columns:[
            {
                title: "<input type='checkbox' id='main-check'>",
                data: "null",
                defaultContent: "<input type='checkbox' class='boxCheck'>",
                orderable:false,
                
                
        } ,
            {
                title:"ID",
                data:"id"
            },
            {
                title:"NAME",
                data: "full_name"
            },
            {
                title:"PHONE",
                data:"phone"
            },
            {
                title: "EMAIL",
                data: "email"
            },  
            {
                title: "STATUS",
                data: "status"
            },
          
        ],
    order: [[1, 'asc']]




    });
    function myCallbackFunction (updatedCell, updatedRow, oldValue) {
        $.ajax({
            type: "POST",
            url: "./backend/authcontroller.php",
            data: JSON.stringify({action:"updateRow",data:updatedRow.data()}),
            success:function(response){
    // console.log(response)
    var jsonResponse = JSON.parse(response);
            var status = jsonResponse.status;
            var message = jsonResponse.message;

  if(status == 200){
toastr.error(message);
  }else{
    alert("not");
  }
                                
                // console.log(response);

            //    var arr = response;
            //     // console.log(arr)
                
            //     console.log(typeof  arr['message'])
                
                table.ajax.reload();
                
            }
        })

    }
    table.MakeCellsEditable({
        "onUpdate": myCallbackFunction,
        "columns": [2,3,4,5],
    
    });

    $('#myTable thead').on('click', '#main-check', function () {
        var row = $(this).closest('tr');
        var data_row = table.row(row).data();
        console.log(data_row);

    var checkboxes = $('.boxCheck', table.rows().nodes());
    checkboxes.prop('checked', $(this).prop('checked'));
});

$('#myTable tbody').on('change', '.boxCheck', function () {
 
    var allCheckboxes = $('.boxCheck', table.rows().nodes());
    var mainCheckbox = $('#main-check');

    var allChecked = allCheckboxes.length === allCheckboxes.filter(':checked').length;

 
    mainCheckbox.prop('checked', allChecked);
});


//     table.on('click', 'tbody .boxCheck', function () {
//         var data_row = table.row($(this).closest('tr')).data();
// //   console.log(data_row.id);
//         if (arr.indexOf(data_row.id) !== -1) {
//     arr.pop();
// } else {
//     arr.push(data_row.id);
// }

// console.log(arr);
// // $("#del_id").val(data_row.id);
// });

$("#deleteBtn").click(function (deletedId) {
    
            // var deletedRow = { data: $("#del_id").val() };

            $.ajax({
                type: "POST",
                url: "./backend/authcontroller.php",
                data: JSON.stringify({action:"deleteRow",data:arr}),
        success: function (response) {
            // console.log(response);

            // var jsonResponse = JSON.parse(response);

            // var status =jsonResponse.status;
            // var message =jsonResponse.messsage;

            // if(status = 200){
            //     toast.success(message);
            //     alert("work");
            // }else{
            //     toast.error(message);
            //     alert("not");
            // }
            table.ajax.reload();
                
                },
                  error: function (error) {
    
                }
            });
        });


});   



</script>
</body>
</html>

<!-- 
var arr = [];

// Function to update the array when a checkbox is clicked
function updateArray(data_row_id) {
    if (arr.indexOf(data_row_id) !== -1) {
        arr.splice(arr.indexOf(data_row_id), 1); // Remove the ID if already present
    } else {
        arr.push(data_row_id); // Add the ID if not present
    }
}

// Event handler for individual checkboxes
table.on('click', 'tbody .boxCheck', function () {
    var data_row = table.row($(this).closest('tr')).data();
    var data_row_id = data_row.id;

    updateArray(data_row_id);

    console.log(arr);
});

// Event handler for header checkbox
$('#myTable thead').on('click', '#main-check', function () {
    var checkboxes = $('.boxCheck', table.rows().nodes());

    checkboxes.prop('checked', $(this).prop('checked'));

    arr = []; // Clear the array when the header checkbox is clicked

    if ($(this).prop('checked')) {
        checkboxes.each(function () {
            var data_row = table.row($(this).closest('tr')).data();
            var data_row_id = data_row.id;
            updateArray(data_row_id);
        });
    }

    console.log(arr);
});

// Event handler for individual checkboxes within tbody
$('#myTable tbody').on('change', '.boxCheck', function () {
    var allCheckboxes = $('.boxCheck', table.rows().nodes());
    var mainCheckbox = $('#main-check');

    var allChecked = allCheckboxes.length === allCheckboxes.filter(':checked').length;

    mainCheckbox.prop('checked', allChecked);

    var data_row = table.row($(this).closest('tr')).data();
    var data_row_id = data_row.id;

    updateArray(data_row_id);

    console.log(arr);
}); -->

<!-- $(document).ready(function () {
    var table = $('#myTable').DataTable();

    $('#myTable thead').on('click', '#main-check', function () {
        var row = $(this).closest('tr');
        var data_row = table.row(row).data();

        if (data_row) {
            console.log(data_row);
        } else {
            console.log("Row data is undefined. Check if the row is selected correctly.");
        }
    });
}); -->
