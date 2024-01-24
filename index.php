<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">
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
<script src="./plugins/toastr/toastr.min.js"></script>


<script>
 
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
                title: "<input type='checkbox' id='checkAll'>",
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
                // console.log(response);
                // <!-- window.location.href = "../index.php"; -->
                toastr.success("checker");
                table.ajax.reload();
                
            }
        })

    }
    table.MakeCellsEditable({
        "onUpdate": myCallbackFunction,
        "columns": [2,3,4,5],
    
    });



    table.on('click', 'tbody .boxCheck', function () {
        var data_row = table.row($(this).closest('tr')).data();

        if (arr.indexOf(data_row.id) !== -1) {
    arr.pop();
} else {
    arr.push(data_row.id);
}

        console.log(arr);
        console.log(data_row.id);
            // $("#del_id").val(data_row.id);
        });

        $("#deleteBtn").click(function (deletedId) {

            // var deletedRow = { data: $("#del_id").val() };

            $.ajax({
                type: "POST",
                url: "./backend/authcontroller.php",
                data: JSON.stringify({action:"deleteRow",data:arr}),
        success: function (response) {

                },
                  error: function (error) {
    
                }
            });
        });


});   



</script>
</body>
</html>


