<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../page/login/login.php"); 
    exit();
}

include '../db/connection.php';

$user_id = $_SESSION['user_id'];

// Retrieve total tasks count
$sqlTotalTasks = "SELECT COUNT(*) AS total_tasks FROM tasks WHERE user_id = $user_id";
$resultTotalTasks = $conn->query($sqlTotalTasks);
$totalTasks = $resultTotalTasks->fetch_assoc()['total_tasks'];

// Retrieve count of pending tasks
$sqlPendingTasks = "SELECT COUNT(*) AS pending_tasks FROM tasks WHERE user_id = $user_id AND status = 'pending'";
$resultPendingTasks = $conn->query($sqlPendingTasks);
$pendingTasks = $resultPendingTasks->fetch_assoc()['pending_tasks'];

// Retrieve count of in-progress tasks
$sqlInProgressTasks = "SELECT COUNT(*) AS in_progress_tasks FROM tasks WHERE user_id = $user_id AND status = 'in progress'";
$resultInProgressTasks = $conn->query($sqlInProgressTasks);
$inProgressTasks = $resultInProgressTasks->fetch_assoc()['in_progress_tasks'];

// Retrieve count of completed tasks
$sqlCompletedTasks = "SELECT COUNT(*) AS completed_tasks FROM tasks WHERE user_id = $user_id AND status = 'completed'";
$resultCompletedTasks = $conn->query($sqlCompletedTasks);
$completedTasks = $resultCompletedTasks->fetch_assoc()['completed_tasks'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/template.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .dashboard-container {
            margin-left: 20px;
        }

        .container-fluid {
            margin-left: -30px;
        }
.card-link{
    text-decoration: none;
    color: black;
}
        .card-icon {
            font-size: 48px;
            margin: auto; /* Center icon horizontally */
            display: block;
        }

        .card-icon-sm {
            font-size: 24px;
            margin-right: 10px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
      
        }

        .card-body p {
            margin-bottom: 0;
        }

        .card-title {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>
            <div class="dashboard-container mt-5">
                <div class="row">
                    <div class="col-md-3">
                    <div class="card">
                <a href="?pg=task" class="card-link">
                    <div class="card-body">
                        <i class="fas fa-tasks card-icon "></i>
                        <h5 class="card-title">Total Tasks</h5>
                        <p class="card-text"><?php echo $totalTasks; ?></p>
                    </div>
                </a>
            </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <i class="far fa-clock card-icon "></i>
                                <h5 class="card-title">Pending Tasks</h5>
                                <p class="card-text"><?php echo $pendingTasks; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <i class="fas fa-spinner card-icon "></i>
                                <h5 class="card-title">In Progress</h5>
                                <p class="card-text"><?php echo $inProgressTasks; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <i class="fas fa-check card-icon "></i>
                                <h5 class="card-title">Completed Tasks</h5>
                                <p class="card-text"><?php echo $completedTasks; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<!-- Add your custom scripts here if needed -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
