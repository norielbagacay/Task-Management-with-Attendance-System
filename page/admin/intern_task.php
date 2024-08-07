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
                <th>#</th>
                <th>User Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Include database connection
        include '../db/connection.php';

        // Fetch users from the database
        $sql = "SELECT id, first_name, middle_name, last_name FROM users";
        $result = $conn->query($sql);

        // Check if there are users
        if ($result->num_rows > 0) {
            $count = 1; // Counter variable
            // Output data of each user
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $count++ . "</td>"; // Increment the counter
                echo "<td>" . $row["first_name"] . " " . ($row["middle_name"] ? $row["middle_name"] . " " : "") . $row["last_name"] . "</td>";
                echo "<td><a href='?pg=view-task&id=" . $row["id"] . "' class='btn btn-primary'>View</a></td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
        }

        // Close database connection
        $conn->close();
        ?>


        </tbody>
    </table>
   
</body>
</html>
