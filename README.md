-- 1. Create Database
CREATE DATABASE IF NOT EXISTS student_db;
USE student_db;

-- 2. Create Students Table
CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  student_id VARCHAR(50),
  department VARCHAR(100),
  major VARCHAR(100),
  dob DATE,
  address TEXT
);

-- 3. Create Enrollments Table
CREATE TABLE IF NOT EXISTS enrollments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id VARCHAR(50) NOT NULL,
  course_code VARCHAR(50) NOT NULL,
  course_title VARCHAR(100),
  semester VARCHAR(50),
  grade VARCHAR(5)
);
