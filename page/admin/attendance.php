<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>

    
</head>
<body>
    <h2>List of Intern</h2>

    <table id="taskTable" class="table table-bordered mt-3">
        <thead>
            <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Total Duration</th>
          
        </tr>
            </tr>
        </thead>
        <tbody>
        <?php
        // Include database connection
        include '../db/connection.php';

      
        // Check if the 'id' parameter is set in the URL
        if (isset($_GET['id'])) {
            // Get the user ID from the URL parameter
            $user_id = $_GET['id'];

            // Fetch attendance records for the specified user ID
            $sql = "SELECT a.*, CONCAT(u.first_name, ' ', COALESCE(u.middle_name, ''), ' ', u.last_name) AS full_name
                    FROM attendance a
                    INNER JOIN users u ON a.user_id = u.id
                    WHERE a.user_id = $user_id";
            $result = $conn->query($sql);
        }
        // Check if there are users' attendance records
        if ($result->num_rows > 0) {
            // Output data of each user's attendance record
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["full_name"]."</td>";
                echo "<td>".$row["date"]."</td>";
                echo "<td>".$row["time_in"]."</td>";
                echo "<td>".$row["time_out"]."</td>";
                echo "<td>".$row["total_duration"]."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No attendance records found</td></tr>";
        }

        // Close database connection
        $conn->close();
        ?>


        </tbody>
    </table>
   
</body>
</html>
