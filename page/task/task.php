<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../page/login/login.php");
    exit();
}

include '../db/connection.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM tasks WHERE user_id = $user_id";
$result = $conn->query($sql);

$tasks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/template.css">
</head>
<body>
    <div class="container mt-5">
        <div class="task-title">
            <h2>My Task</h2>
        </div>

        <?php include "../page/task/addModal.php"; ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTaskModal">
            Add Task
        </button> 
        <?php include "../page/task/deleteModal.php"; ?>
        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>

        <br>
        <br>
 
        <div class="form-group row">
        <label for="priorityFilter" style="font-size: 18px; font-weight: bold; color: #333;margin-left: 20px; ">Priority:</label>
            <div class="col-sm-2">
                <select class="form-control" id="priorityFilter">
                    <option value="">All</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>
        </div>




        
        <table id="taskTable" class="table table-bordered mt-3">
            <!-- Table Header -->
            <thead>
                <tr>
                    <th style="width: 20px !important;"><input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)" /></th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr class="taskRow" data-priority="<?php echo $task['priority']; ?>">
                        <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="<?php echo $task['id']; ?>" /></td>
                        <td><?php echo $task['title']; ?></td>
                        <td><?php echo $task['description']; ?></td>
                        <td><?php echo $task['created_at']; ?></td>
                        <td><?php echo $task['updated_at']; ?></td>
                        <td><?php echo $task['priority']; ?></td>
                        <td style="color: <?php echo ($task['status'] == 'pending') ? 'red' : ''; ?>"><?php echo $task['status']; ?></td>
                        <td>
                            <button class="btn btn-primary editBtn" data-toggle="modal" data-target="#editModal<?php echo $task['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</button>
                            <?php include "../page/task/editModal.php"; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
       
    </div>

    <form id="deleteForm" action="?pg=delete_task" method="post">
        <!-- Hidden input field to pass the selected tasks for deletion -->
        <input type="hidden" name="tasksToDelete" id="tasksToDelete">
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize DataTables plugin
            var table = $('#taskTable').DataTable();

            // Priority filter change event
            $('#priorityFilter').change(function() {
                var priority = $(this).val();
                if (priority === '') {
                    table.columns(5).search('').draw(); // Reset filter
                } else {
                    table.columns(5).search(priority).draw(); // Filter by priority
                }
            });
        });

        function checkMain(x) {
            var checked = $(x).prop('checked');
            $('.cbxMain').prop('checked', checked);
            $('.chk_delete').prop('checked', checked);
        }

        $(document).ready(function (){
            $('.chk_delete').click(function () {
                if ($('.chk_delete:checked').length == $('.chk_delete').length) {
                    $('.cbxMain').prop('checked', true);
                }
                else {
                    $('.cbxMain').prop('checked', false);
                }
            }); 

            $('#confirmDeleteBtn').click(function() {
                var selectedTasks = [];
                $('.chk_delete:checked').each(function() {
                    selectedTasks.push($(this).val());
                });
                $('#tasksToDelete').val(selectedTasks.join(','));
                $('#deleteForm').submit();
            });
        });
    </script>
</body>
</html>

