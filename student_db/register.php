<?php
include 'db.php';  // Database connection

// Check if form data is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $student_id = $_POST['student_id'];
    $department = $_POST['department'];
    $major = $_POST['major'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    // Validate required fields
    if (empty($name) || empty($email)) {
        echo "<span class='error'>Name and Email are required.</span>";
        exit;
    }

    // Prepare the SQL query to insert the student data into the database
    $stmt = $mysqli->prepare("INSERT INTO students (name, email, student_id, department, major, dob, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $student_id, $department, $major, $dob, $address);

    // Execute the query and check if the data is inserted successfully
    if ($stmt->execute()) {
        echo "<span class='message'>Student registered successfully!</span>";
    } else {
        echo "<span class='error'>Error: " . $stmt->error . "</span>";
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "<span class='error'>Invalid request method.</span>";
}
?>
