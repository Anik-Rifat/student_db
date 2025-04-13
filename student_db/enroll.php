<?php
include 'db.php';

$student_id   = $_POST['student_id'] ?? '';
$course_code  = $_POST['course_code'] ?? '';
$course_title = $_POST['course_title'] ?? '';
$semester     = $_POST['semester'] ?? '';

if (empty($student_id) || empty($course_code)) {
    echo "<span class='error'>Student ID and Course Code are required.</span>";
    exit;
}

$stmt = $mysqli->prepare("INSERT INTO enrollments (student_id, course_code, course_title, semester) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $student_id, $course_code, $course_title, $semester);

if ($stmt->execute()) {
    echo "<span class='message'>Enrollment successful!</span>";
} else {
    echo "<span class='error'>Error: " . $stmt->error . "</span>";
}

$stmt->close();
$mysqli->close();
?>
