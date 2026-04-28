CREATE DATABASE IF NOT EXISTS college_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE college_erp;

CREATE TABLE departments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL UNIQUE,
  hod_faculty_id BIGINT UNSIGNED NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('Super Admin','Principal','Accountant','Faculty','Librarian','Hostel Manager','Student') NOT NULL,
  last_login_at DATETIME NULL,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  department_id BIGINT UNSIGNED NOT NULL,
  name VARCHAR(120) NOT NULL,
  course_type ENUM('Degree','Diploma','Certificate') NOT NULL,
  duration_semesters TINYINT UNSIGNED NOT NULL,
  annual_fee DECIMAL(12,2) NOT NULL,
  seat_intake INT UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_course_department FOREIGN KEY (department_id) REFERENCES departments(id)
);

CREATE TABLE students (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  course_id BIGINT UNSIGNED NOT NULL,
  student_code VARCHAR(40) NOT NULL UNIQUE,
  semester TINYINT UNSIGNED NOT NULL,
  guardian_name VARCHAR(150) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  address TEXT,
  admission_date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_student_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_student_course FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE faculty (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  department_id BIGINT UNSIGNED NOT NULL,
  qualification VARCHAR(120) NOT NULL,
  experience_years DECIMAL(4,1) DEFAULT 0,
  salary DECIMAL(12,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_faculty_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_faculty_department FOREIGN KEY (department_id) REFERENCES departments(id)
);

ALTER TABLE departments ADD CONSTRAINT fk_department_hod FOREIGN KEY (hod_faculty_id) REFERENCES faculty(id);

CREATE TABLE subjects (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  course_id BIGINT UNSIGNED NOT NULL,
  faculty_id BIGINT UNSIGNED NULL,
  title VARCHAR(150) NOT NULL,
  code VARCHAR(30) NOT NULL UNIQUE,
  semester TINYINT UNSIGNED NOT NULL,
  CONSTRAINT fk_subject_course FOREIGN KEY (course_id) REFERENCES courses(id),
  CONSTRAINT fk_subject_faculty FOREIGN KEY (faculty_id) REFERENCES faculty(id)
);

CREATE TABLE attendance (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id BIGINT UNSIGNED NOT NULL,
  subject_id BIGINT UNSIGNED NOT NULL,
  attendance_date DATE NOT NULL,
  status ENUM('Present','Absent','Late') NOT NULL,
  CONSTRAINT fk_attendance_student FOREIGN KEY (student_id) REFERENCES students(id),
  CONSTRAINT fk_attendance_subject FOREIGN KEY (subject_id) REFERENCES subjects(id),
  UNIQUE KEY uq_attendance (student_id, subject_id, attendance_date)
);

CREATE TABLE fees (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id BIGINT UNSIGNED NOT NULL,
  invoice_no VARCHAR(50) NOT NULL UNIQUE,
  amount DECIMAL(12,2) NOT NULL,
  due_date DATE NOT NULL,
  status ENUM('Pending','Paid','Partial') DEFAULT 'Pending',
  CONSTRAINT fk_fees_student FOREIGN KEY (student_id) REFERENCES students(id)
);

CREATE TABLE payments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  fee_id BIGINT UNSIGNED NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  paid_at DATETIME NOT NULL,
  method ENUM('Cash','Card','UPI','Online') NOT NULL,
  reference_no VARCHAR(100),
  CONSTRAINT fk_payment_fee FOREIGN KEY (fee_id) REFERENCES fees(id)
);

CREATE TABLE exams (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  course_id BIGINT UNSIGNED NOT NULL,
  exam_name VARCHAR(120) NOT NULL,
  exam_type ENUM('Internal','Semester') NOT NULL,
  exam_date DATE NOT NULL,
  session ENUM('Morning','Afternoon','Evening') NOT NULL,
  CONSTRAINT fk_exam_course FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE results (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  exam_id BIGINT UNSIGNED NOT NULL,
  student_id BIGINT UNSIGNED NOT NULL,
  marks_obtained DECIMAL(5,2) NOT NULL,
  gpa DECIMAL(3,2),
  cgpa DECIMAL(3,2),
  rank_position INT UNSIGNED,
  CONSTRAINT fk_result_exam FOREIGN KEY (exam_id) REFERENCES exams(id),
  CONSTRAINT fk_result_student FOREIGN KEY (student_id) REFERENCES students(id)
);

CREATE TABLE books (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  isbn VARCHAR(30) NOT NULL UNIQUE,
  title VARCHAR(200) NOT NULL,
  author VARCHAR(150) NOT NULL,
  total_copies INT UNSIGNED NOT NULL,
  available_copies INT UNSIGNED NOT NULL
);

CREATE TABLE hostel_rooms (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  room_no VARCHAR(20) NOT NULL UNIQUE,
  capacity TINYINT UNSIGNED NOT NULL,
  occupied TINYINT UNSIGNED DEFAULT 0,
  warden_name VARCHAR(120)
);

CREATE TABLE transport_routes (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  route_name VARCHAR(120) NOT NULL,
  vehicle_no VARCHAR(40) NOT NULL,
  driver_name VARCHAR(120) NOT NULL,
  pickup_points TEXT
);

CREATE TABLE notices (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  content TEXT NOT NULL,
  audience ENUM('All','Students','Faculty','Staff') DEFAULT 'All',
  publish_at DATETIME NOT NULL
);

CREATE TABLE leave_requests (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  leave_type VARCHAR(80) NOT NULL,
  from_date DATE NOT NULL,
  to_date DATE NOT NULL,
  reason TEXT,
  status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
  CONSTRAINT fk_leave_user FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE settings (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(120) NOT NULL UNIQUE,
  setting_value TEXT,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
