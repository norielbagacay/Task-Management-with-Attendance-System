<?php
date_default_timezone_set('Asia/Manila');

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../page/login/login.php");
    exit();
}

include '../db/connection.php';

// Check if user has already clocked in for the current date
$userId = $_SESSION['user_id'];
$currentDate = date('Y-m-d');
$sql = "SELECT * FROM attendance WHERE user_id = $userId AND date = '$currentDate'";
$result = $conn->query($sql);
$clockedIn = ($result->num_rows > 0);
$clockedOut = false;

// Handle clock in/out form submission and deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'in') {
        if (!$clockedIn) {
            // Get current date and time
            $date = date('Y-m-d');
            $timeIn = date('H:i:s');
            
            // Insert attendance record
            $sql = "INSERT INTO attendance (user_id, date, time_in) VALUES ($userId, '$date', '$timeIn')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                // Refresh the page after submitting the form to avoid resubmission
                header("Refresh:0");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "You have already clocked in for today.";
        }
    } elseif ($_POST['action'] === 'out') {
        if ($clockedIn && !$clockedOut) {
            // Get current time
            $timeOut = date('H:i:s');
            
            // Update attendance record with time out and calculate total duration
            $sql = "UPDATE attendance SET time_out = '$timeOut', total_duration = TIMEDIFF('$timeOut', time_in) WHERE user_id = $userId AND date = '$currentDate'";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
                $clockedOut = true;
                // Refresh the page after submitting the form to avoid resubmission
                header("Refresh:0");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif ($clockedOut) {
            echo "You have already clocked out for today.";
        } else {
            echo "You need to clock in first.";
        }
    } elseif (isset($_POST['delete'])) {
        // Check if delete button is clicked
        $deleteId = $_POST['delete_id'];
        $sql = "DELETE FROM attendance WHERE id = $deleteId";
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
            // Refresh the page after deleting the record
            header("Refresh:0");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT u.username, a.date, a.time_in, a.time_out, a.total_duration, a.id
        FROM attendance a
        INNER JOIN users u ON a.user_id = u.id
        WHERE u.id = $user_id
        ORDER BY a.date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <link rel="stylesheet" href="../css/attendance.css">
    <link rel="stylesheet" href="../css/template.css">
</head>
<body>
    <h2>Attendance</h2>
    <!-- Form for the action button -->
    <div class="attendance-button">
    <form method="post">
    <?php if (!$clockedIn || $clockedOut): ?>
        <input type="hidden" name="action" value="in">
        <button class="btn btn-primary" type="submit">In</button>
    <?php else: ?>
        <input type="hidden" name="action" value="out">
        <button class="btn btn-danger" type="submit">Out</button>
    <?php endif; ?>
    </form>
</div>


<table id="taskTable" class="table table-bordered mt-3">
        <tr>
          
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Total Duration</th>
            <th>Delete</th>
        </tr>
        
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $timeIn = strtotime($row["time_in"]);
                $timeOut = strtotime($row["time_out"]);
                
                if ($row['time_out'] === null || $row['time_out'] === '') {
                    $totalDuration = "N/A"; // Set total duration to N/A if time_out is null or empty
                } else {
                    // Calculate total duration only if time_out is set
                    $timeIn = strtotime($row["time_in"]);
                    $timeOut = strtotime($row["time_out"]);
                    $durationSeconds = $timeOut - $timeIn;
                    $hours = floor($durationSeconds / 3600);
                    $minutes = floor(($durationSeconds % 3600) / 60);
                    $seconds = $durationSeconds % 60;
                
                    // Format the total duration
                    $totalDuration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
                }
                

                echo "<tr>";
                echo "<td>".$row["date"]."</td>";
                echo "<td>".$row["time_in"]."</td>";
                echo "<td>".$row["time_out"]."</td>";
                echo "<td>".$totalDuration."</td>"; // Display the total duration
                echo "<td><form method='post'><input type='hidden' name='delete_id' value='".$row["id"]."'><button type='submit' name='delete' class='btn btn-danger'>Delete</button></form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No attendance records found</td></tr>";
        }
        ?>

    </table>


</body>
</html>
<script>
$(document).ready( function () {
    $('#taskTable').DataTable();
} );
</script>


<?php
// Close the database connection
$conn->close();
?>
