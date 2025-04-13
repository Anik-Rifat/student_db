<?php
include 'db.php';  // Include the database connection file

// SQL query to fetch all students
$query = "SELECT * FROM students";  
$result = $mysqli->query($query);  // Execute the query

// Check if the query was successful and if there are any results
if ($result) {
    if ($result->num_rows > 0) {
        // Loop through the results and generate the HTML for each student
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['student_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['department']) . '</td>';
            echo '<td>' . htmlspecialchars($row['major']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>
                    <button onclick="editStudent(\'' . $row['student_id'] . '\')">Edit</button>
                    <button onclick="deleteStudent(\'' . $row['student_id'] . '\')">Delete</button>
                  </td>';
            echo '</tr>';
        }
    } else {
        echo "<tr><td colspan='7'>No students found.</td></tr>";  // If no records found
    }
} else {
    echo "<tr><td colspan='7'>Error fetching data: " . $mysqli->error . "</td></tr>";
}

$mysqli->close();
?>
