<?php
/**
 * Global configuration and demo data store.
 * This is intentionally array-based so it can be swapped with MySQL queries later.
 */
session_start();

// Base URL helper for simple local setup (XAMPP/WAMP compatible).
define('APP_NAME', 'College Management System');
define('BASE_PATH', __DIR__);
$docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : null;
$projectUrl = '';
if ($docRoot) {
    $projectUrl = str_replace('\\', '/', str_replace($docRoot, '', realpath(BASE_PATH)));
}
define('APP_URL', rtrim($projectUrl, '/'));

// Demo users with password hashes ready for real auth migration.
$demoUsers = [
    'admin@gmail.com' => ['name' => 'System Admin', 'role' => 'Admin', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    'staff@gmail.com' => ['name' => 'Academic Staff', 'role' => 'Staff', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    'student@gmail.com' => ['name' => 'Student User', 'role' => 'Student', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
];

$courses = [
    ['id' => 1, 'name' => 'BCA', 'duration' => '3 Years', 'fees' => 90000, 'subjects' => 24, 'seats' => 120, 'teacher' => 'Aman Singh'],
    ['id' => 2, 'name' => 'BBA', 'duration' => '3 Years', 'fees' => 85000, 'subjects' => 20, 'seats' => 100, 'teacher' => 'Neha Verma'],
    ['id' => 3, 'name' => 'MBA', 'duration' => '2 Years', 'fees' => 150000, 'subjects' => 18, 'seats' => 80, 'teacher' => 'Rohit Sood'],
    ['id' => 4, 'name' => 'BCOM', 'duration' => '3 Years', 'fees' => 70000, 'subjects' => 22, 'seats' => 110, 'teacher' => 'Pooja Jain'],
    ['id' => 5, 'name' => 'MCA', 'duration' => '2 Years', 'fees' => 140000, 'subjects' => 16, 'seats' => 70, 'teacher' => 'Karan Patel'],
];

$teachers = [
    ['id' => 101, 'name' => 'Aman Singh', 'email' => 'aman@college.edu', 'department' => 'Computer Science', 'salary' => 65000, 'subject' => 'Data Structures', 'contact' => '9876501231'],
    ['id' => 102, 'name' => 'Neha Verma', 'email' => 'neha@college.edu', 'department' => 'Management', 'salary' => 62000, 'subject' => 'Business Communication', 'contact' => '9876501232'],
    ['id' => 103, 'name' => 'Rohit Sood', 'email' => 'rohit@college.edu', 'department' => 'Management', 'salary' => 78000, 'subject' => 'Strategic Management', 'contact' => '9876501233'],
    ['id' => 104, 'name' => 'Pooja Jain', 'email' => 'pooja@college.edu', 'department' => 'Commerce', 'salary' => 60000, 'subject' => 'Financial Accounting', 'contact' => '9876501234'],
    ['id' => 105, 'name' => 'Karan Patel', 'email' => 'karan@college.edu', 'department' => 'Computer Science', 'salary' => 73000, 'subject' => 'Machine Learning', 'contact' => '9876501235'],
    ['id' => 106, 'name' => 'Riya Mehra', 'email' => 'riya@college.edu', 'department' => 'Mathematics', 'salary' => 58000, 'subject' => 'Statistics', 'contact' => '9876501236'],
    ['id' => 107, 'name' => 'Arjun Nair', 'email' => 'arjun@college.edu', 'department' => 'Economics', 'salary' => 61000, 'subject' => 'Micro Economics', 'contact' => '9876501237'],
    ['id' => 108, 'name' => 'Sara Khan', 'email' => 'sara@college.edu', 'department' => 'English', 'salary' => 55000, 'subject' => 'Professional Writing', 'contact' => '9876501238'],
];

$students = [];
$studentNames = ['Aarav Sharma','Vivaan Gupta','Aditya Rao','Ananya Sharma','Ishita Jain','Rahul Das','Sneha Kapoor','Priya Nair','Kabir Mehta','Diya Patel','Rohan Yadav','Meera Singh','Aisha Khan','Arnav Sethi','Kriti Joshi','Tanya Roy','Yash Malhotra','Nidhi Bansal','Dev Verma','Sana Ali'];
for ($i = 0; $i < 20; $i++) {
    $course = $courses[$i % count($courses)]['name'];
    $totalFee = 100000;
    $paid = ($i % 3 === 0) ? 100000 : (($i % 2 === 0) ? 70000 : 45000);
    $students[] = [
        'id' => 1001 + $i,
        'photo' => 'https://ui-avatars.com/api/?name=' . urlencode($studentNames[$i]) . '&background=2b73ff&color=fff',
        'name' => $studentNames[$i],
        'email' => strtolower(str_replace(' ', '.', $studentNames[$i])) . '@mail.com',
        'course' => $course,
        'year' => 'Year ' . (($i % 3) + 1),
        'fees' => $paid,
        'total_fee' => $totalFee,
        'status' => $i % 4 === 0 ? 'Inactive' : 'Active',
        'dob' => '200' . ($i % 4) . '-0' . (($i % 9) + 1) . '-1' . ($i % 9),
        'parent' => 'Parent ' . ($i + 1),
        'address' => 'City Block ' . ($i + 1),
        'contact' => '900000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
    ];
}

$books = [];
for ($i = 1; $i <= 15; $i++) {
    $books[] = [
        'id' => 'BK' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
        'title' => 'Academic Book ' . $i,
        'author' => 'Author ' . $i,
        'quantity' => rand(3, 12),
        'status' => $i % 4 === 0 ? 'Issued' : 'Available',
    ];
}

$notices = [
    ['id' => 1, 'title' => 'Holiday Notice', 'date' => '2026-05-01', 'priority' => 'Important'],
    ['id' => 2, 'title' => 'Exam Date Declared', 'date' => '2026-05-03', 'priority' => 'High'],
    ['id' => 3, 'title' => 'New Semester Starts', 'date' => '2026-06-10', 'priority' => 'Important'],
    ['id' => 4, 'title' => 'Library Week Event', 'date' => '2026-05-12', 'priority' => 'Normal'],
    ['id' => 5, 'title' => 'Fee Submission Reminder', 'date' => '2026-05-15', 'priority' => 'High'],
];

$monthlyAdmissions = [25, 30, 42, 38, 50, 61, 55, 46, 39, 60, 67, 73];
$feeCollection = [2.3, 2.8, 3.1, 3.4, 3.0, 4.2, 3.8, 4.4, 4.1, 4.7, 4.3, 5.1];
$attendanceTrend = [84, 86, 83, 89, 91, 87, 90, 92, 88, 86, 89, 93];

function sanitize($value) {
    return htmlspecialchars(trim((string) $value), ENT_QUOTES, 'UTF-8');
}

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header('Location: ' . APP_URL . '/login.php');
        exit;
    }
}

function currency($amount) {
    return '₹' . number_format((float) $amount, 0);
}
