<?php
include 'db.php';  // Include the database connection file

// Get student ID from POST data
$student_id = $_POST['student_id'] ?? '';

if (empty($student_id)) {
    echo "<tr><td colspan='4'>No student ID provided.</td></tr>";
    exit;
}

// Prepare the SQL query to fetch course history for the given student ID
$stmt = $mysqli->prepare("SELECT course_code, course_title, semester, grade FROM enrollments WHERE student_id = ?");
$stmt->bind_param("s", $student_id);  // Bind the student ID to the query
$stmt->execute();  // Execute the query

// Get the result
$result = $stmt->get_result();

// Check if there are any results
if ($result && $result->num_rows > 0) {
    // Loop through the results and generate the HTML for each enrollment record
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
        echo "<td>" . htmlspecialchars($row['course_title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
        echo "<td>" . (empty($row['grade']) ? '-' : htmlspecialchars($row['grade'])) . "</td>";
        echo "</tr>";
    }
} else {
    // If no records are found, display a message
    echo "<tr><td colspan='4'>No enrollment history found for this student.</td></tr>";
}

// Close the statement and database connection
$stmt->close();
$mysqli->close();
?>
