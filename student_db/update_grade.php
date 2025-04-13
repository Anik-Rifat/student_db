<?php
include 'db.php';  // Include the database connection file

// Get data from the form (using POST method)
$student_id = $_POST['student_id'] ?? '';
$course_code = $_POST['course_code'] ?? '';
$grade = $_POST['grade'] ?? '';

// Check if required fields are provided
if (empty($student_id) || empty($course_code) || empty($grade)) {
    echo "<span class='error'>Student ID, Course Code, and Grade are required.</span>";
    exit;
}

// Prepare the SQL query to update the grade in the enrollments table
$stmt = $mysqli->prepare("UPDATE enrollments SET grade=? WHERE student_id=? AND course_code=?");
$stmt->bind_param("sss", $grade, $student_id, $course_code);

// Execute the query
if ($stmt->execute()) {
    echo "<span class='message'>Grade updated successfully!</span>";
} else {
    echo "<span class='error'>Error: " . $stmt->error . "</span>";
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$mysqli->close();
?>
