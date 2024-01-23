<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editable DataTable</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/t/buttons-2.1.2/b-2.1.2/sl-1.3.3/datatables.min.css">
</head>
<body>

<table id="editableTable" class="display" style="width:100%">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>John Doe</td>
      <td>john@example.com</td>
    </tr>
    <tr>
      <td>Jane Doe</td>
      <td>jane@example.com</td>
    </tr>
    <!-- Add more rows as needed -->
  </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/t/buttons-2.1.2/b-2.1.2/sl-1.3.3/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.2.3/dist/jquery.tabledit.min.js"></script>

<script>
  $(document).ready(function() {
    $('#editableTable').DataTable({
      "paging": true,
      "ordering": true,
      "info": true,
      "searching": true,
      "select": true,
      "buttons": [
        'excel', 'pdf', 'print'
      ]
    });

    // Initialize the Tabledit plugin for inline editing
    $('#editableTable').Tabledit({
      url: 'your_update_server_script.php', // Replace with your server-side script to handle updates
      columns: {
        identifier: [0, 'Name'], // 0 is the column index, 'Name' is the column name
        editable: [[1, 'Email']]
      },
      restoreButton: false,
      onSuccess: function(data, textStatus, jqXHR) {
        console.log('Data updated successfully');
      },
      onFail: function(jqXHR, textStatus, errorThrown) {
        console.log('Data update failed');
      }
    });
  });
</script>

</body>
</html>
