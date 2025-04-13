<?php
include 'db.php';  // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Management System</title>
  <style>
    :root {
      --primary: #2a9d8f;
      --accent: #e76f51;
      --bg: #f1f1f1;
      --text: #222;
      --light: #fff;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--bg);
      margin: 0;
      padding: 0;
      color: var(--text);
    }

    header {
      background: var(--primary);
      color: var(--light);
      padding: 20px;
      text-align: center;
    }

    nav {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      background: var(--light);
      padding: 10px;
      border-bottom: 2px solid #ccc;
    }

    nav a {
      margin: 5px 15px;
      font-weight: bold;
      cursor: pointer;
      color: var(--primary);
      text-decoration: none;
    }

    nav a:hover {
      color: var(--accent);
    }

    .container {
      max-width: 900px;
      margin: auto;
      padding: 20px;
    }

    .section {
      display: none;
      background: var(--light);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .active {
      display: block;
    }

    form input, form select, form textarea, form button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    form button {
      background: var(--primary);
      color: var(--light);
      border: none;
      cursor: pointer;
      transition: 0.3s;
    }

    form button:hover {
      background: var(--accent);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background: var(--primary);
      color: var(--light);
    }

    .message { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }

    @media (max-width: 768px) {
      nav { flex-direction: column; align-items: center; }
      table, thead, tbody, th, td, tr { display: block; }
      thead tr { display: none; }
      td { position: relative; padding-left: 50%; margin-bottom: 10px; }
      td::before {
        position: absolute; left: 10px; top: 12px;
        white-space: nowrap; font-weight: bold; color: #888;
      }
    }
  </style>
</head>
<body>
  <header><h1>Student Management System</h1></header>

  <nav>
    <a onclick="showSection('register')">Add Student</a>
    <a onclick="showSection('list')">Student List</a>
    <a onclick="showSection('enroll')">Enroll in Course</a>
    <a onclick="showSection('history')">Enrollment History</a>
    <a onclick="showSection('grade')">Update Grade</a>
  </nav>

  <div class="container">

    <!-- Student Registration -->
    <div class="section active" id="register">
      <h2>Student Registration</h2>
      <form id="registerForm">
        <input name="name" placeholder="Name (required)" required />
        <input name="email" placeholder="Email (required)" required />
        <input name="student_id" placeholder="Student ID" />
        <select name="department">
          <option value="">Select Department</option>
          <option>CSE</option><option>EEE</option><option>BBA</option>
        </select>
        <select name="major">
          <option value="">Select Major</option>
          <option>AI</option><option>Networks</option><option>Software</option>
        </select>
        <input type="date" name="dob" />
        <textarea name="address" placeholder="Address"></textarea>
        <button type="submit">Submit</button>
        <div id="registerMsg"></div>
      </form>
    </div>

    <!-- Student List -->
    <div class="section" id="list">
  <h2>Student List</h2>
  <table id="studentTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Student ID</th>
        <th>Department</th>
        <th>Major</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>  <!-- This is where the student data will be dynamically inserted -->
  </table>
</div>


    <!-- Course Enrollment -->
    <div class="section" id="enroll">
      <h2>Course Enrollment</h2>
      <form id="enrollForm">
        <input name="student_id" placeholder="Student ID (required)" required />
        <input name="course_code" placeholder="Course Code (required)" required />
        <input name="course_title" placeholder="Course Title" />
        <select name="semester">
          <option value="">Select Semester</option>
          <option>Spring</option><option>Summer</option><option>Fall</option>
        </select>
        <button type="submit">Enroll</button>
        <div id="enrollMsg"></div>
      </form>
    </div>

    <!-- Enrollment History -->
    <div class="section" id="history">
      <h2>Enrollment History</h2>
      <form id="historyForm">
        <input name="student_id" placeholder="Student ID" required />
        <button type="submit">Search</button>
      </form>
      <table id="historyTable">
        <thead><tr><th>Course Code</th><th>Course Title</th><th>Semester</th><th>Grade</th></tr></thead>
        <tbody></tbody>
      </table>
      <div id="historyMsg"></div>
    </div>

    <!-- Grade Update -->
    <div class="section" id="grade">
      <h2>Update Grade</h2>
      <form id="gradeForm">
        <input name="student_id" placeholder="Student ID" required />
        <input name="course_code" placeholder="Course Code" required />
        <input name="grade" placeholder="Grade" required />
        <button type="submit">Update</button>
        <div id="gradeMsg"></div>
      </form>
    </div>

  </div>

  <script>
    const showSection = id => {
      document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
      document.getElementById(id).classList.add('active');
    };

    const loadStudentList = async () => {
  const res = await fetch("get-students.php");  // Fetch student data from PHP
  if (res.ok) {
    const data = await res.text();  // Receive raw HTML from PHP
    document.querySelector("#studentTable tbody").innerHTML = data;  // Insert HTML data into the table body
  } else {
    console.log("Error loading students");
  }
};

// Trigger loading of student list when the "Student List" tab is clicked
document.querySelector("nav a:nth-child(2)").addEventListener("click", () => {
  showSection('list');  // Show the "Student List" section
  loadStudentList();    // Load student data dynamically when clicked
});



    document.getElementById("registerForm").onsubmit = async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const res = await fetch("register.php", { method: "POST", body: formData });
      const data = await res.text();
      document.getElementById("registerMsg").innerHTML = data;
      e.target.reset();
      loadStudentList();  // Refresh student list after registration
    };

    document.getElementById("enrollForm").onsubmit = async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const res = await fetch("enroll.php", { method: "POST", body: formData });
      const data = await res.text();
      document.getElementById("enrollMsg").innerHTML = data;
      e.target.reset();
    };

    document.getElementById("historyForm").onsubmit = async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const res = await fetch("history.php", { method: "POST", body: formData });
      const rows = await res.text();  // Insert raw HTML for enrollment history
      document.querySelector("#historyTable tbody").innerHTML = rows;
    };

    document.getElementById("gradeForm").onsubmit = async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const res = await fetch("update_grade.php", { method: "POST", body: formData });
      const data = await res.text();
      document.getElementById("gradeMsg").innerHTML = data;
      e.target.reset();
    };

    document.querySelector("nav a:nth-child(2)").addEventListener("click", () => {
  showSection('list');  // Show the "Student List" section
  loadStudentList();    // Load student data dynamically when clicked
});


    const deleteStudent = async (studentId) => {
      if (confirm(`Are you sure you want to delete Student ID: ${studentId}?`)) {
        const res = await fetch(`delete-student.php?student_id=${studentId}`);
        const result = await res.text();
        alert(result);
        loadStudentList();
      }
    };

    const editStudent = (studentId) => {
      alert(`Edit function not implemented yet for Student ID: ${studentId}`);
    };
  </script>

</body>
</html>
