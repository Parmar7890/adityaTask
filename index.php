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
    var selectedIds = [];
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
                                
        
                
                table.ajax.reload();
                
            }
        })

    }
    table.MakeCellsEditable({
        "onUpdate": myCallbackFunction,
        "columns": [2,3,4,5],
    
    });

    $('#myTable thead').on('click', '#main-check', function () {
        var isChecked = $(this).prop('checked');
        $('.boxCheck').prop('checked', isChecked);
        selectedIds = []; // Clear the array before selecting new IDs
        if (isChecked) {
            $('.boxCheck').each(function () {
                selectedIds.push($(this).closest('tr').find('td:eq(1)').text());
            });
        }
        console.log(selectedIds);
    });

    $('#myTable tbody').on('click', '.boxCheck', function () {
        var isChecked = $(this).prop('checked');
        var rowId = $(this).closest('tr').find('td:eq(1)').text();
        if (isChecked) {
            selectedIds.push(rowId);
        } else {
            var index = selectedIds.indexOf(rowId);
            if (index !== -1) {
                selectedIds.splice(index, 1);
            }
        }
        console.log(selectedIds);
    });

    $("#deleteBtn").click(function () {
        $.ajax({
            type: "POST",
            url: "./backend/authcontroller.php",
            data: JSON.stringify({ action: "deleteRow", data: selectedIds }),
            contentType: 'application/json', // Specify the content type
            success: function (response) {
                var jsonResponse = JSON.parse(response);

                var status =jsonResponse.status;
                var message =jsonResponse.message;
                // console.log(status,message);
                // Handle success response
                console.log(response);
                // You might want to update your UI here if necessary
            },
            error: function (error) {
                // Handle error response
                console.error(error);
                // You might want to show an error message to the user here
            }
        });
    });


});   



</script>
</body>
</html>
