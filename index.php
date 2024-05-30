<?php
include 'connect.php';

$sql = "SELECT * FROM articles";
$articles = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <h2>Articles lists  </h2>
    <table id="example" class="display" style="width:100%">
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th>Slug</th>
        </tr>
        <?php
        if ($articles->num_rows > 0) {
            while($row = $articles->fetch_assoc()) {
                echo "<button class='delete' data-id=".$row["id"].">Delete</button>";
                echo "<button class='update'>Update</button>";
                echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["Title"]."</td>
                    <td>".$row["Description"]."</td>
                    <td>".$row["Category"]."</td>
                    <td>".$row["Slug"]."</td>
                    </tr>";
            }
        } else {
            echo "No article";
        }
        ?>
    </table>

    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update</h2>
            <form id="updateForm">
                <input type="hidden" id="updateId" name="id">
                Title: <input type="text" id="updateTitle" name="updateTitle"><br><br>
                Description: <input type="text" id="updateDescription" name="updateDescription"><br><br>
                Category: <input type="text" id="updateCategory" name="updateCategory"><br><br>
                Slug: <input type="text" id="updateSlug" name="updateSlug"><br><br>
                <input type="submit" value="Update">
                <input type="button" value="Cancel" class="cancel">
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
        $('#date-filter').on('change', function() {
                var date = $(this).val();
                $('#myTable').DataTable().search(date).draw();
            });
        $('.update').click(function() {
                var id = $(this).data('id');
                $('#updateId').val(id);
                $('#updateModal').css('display', 'block');
                $.ajax({
                    url: 'get_record.php',
                    type: 'GET',
                    data: {id: id},
                    dataType: 'json',
                    success: function(data) {
                        $('#updateName').val(data.name);
                        $('#updateEmail').val(data.email);
                    }
                });
            });
        $('.close').click(function() {
                $('#updateModal').css('display', 'none');
            });

        $('#updateForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "UpdateData.php",
                    data: formData,
                    success: function(response) {
                        location.reload();
                    }
                });
            });

        $('.delete').click(function() {
            var ID = $(this).data('id');
            if (confirm("Are you sure you want to delete this task?")) {
                $.ajax({
                    url: 'deleteArticle.php',
                    type: 'POST',
                    data: {ID: ID},
                    success: function(response) {
                        $('[data-id="' + id + '"]').remove();
                    },
                    error: function(xhr, status, error) {
                    }
                });
            }
        });

    </script>
</body>
</html>

<?php
$conn->close();
?>
