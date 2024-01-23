<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">
    <title>data tables</title>
</head>
<body>
    
<table id="myTable">
</table>

<script src="./plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="./plugins/CellEdit/js/dataTables.cellEdit.js"></script>
<script src="./plugins/toastr/toastr.min.js"></script>



<script>
    // toastr.success(response["message"]);
$(document).ready(function (){
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
            
        ]
    });
    function myCallbackFunction (updatedCell, updatedRow, oldValue) {
        $.ajax({
            type: "POST",
            url: "./backend/authcontroller.php",
            data: JSON.stringify({action:"updateRow",data:updatedRow.data()}),
            success:function(response){
                console.log(response);
                // <!-- window.location.href = "../index.php"; -->
                toastr.success("checker");
                table.ajax.reload();
                
            }
        })
        // console.log("The new value for the cell is: " + updatedCell.data());
        // console.log(updatedRow.data());
    }

    table.MakeCellsEditable({
        "onUpdate": myCallbackFunction
    });
});    	
</script>
</body>
</html>