<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

const APP_NAME = 'Nimbus College ERP';

$demoUsers = [
    'admin@college.com' => ['name' => 'Aarav Kapoor', 'role' => 'Super Admin', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    'faculty@college.com' => ['name' => 'Dr. Nidhi Sharma', 'role' => 'Faculty', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    'student@college.com' => ['name' => 'Meera Joshi', 'role' => 'Student', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    'principal@college.com' => ['name' => 'Prof. Vivek Rao', 'role' => 'Principal', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    'accountant@college.com' => ['name' => 'Ritu Jain', 'role' => 'Accountant', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    'librarian@college.com' => ['name' => 'Shahid Khan', 'role' => 'Librarian', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
    'hostel@college.com' => ['name' => 'Priya Nair', 'role' => 'Hostel Manager', 'password' => password_hash('123456', PASSWORD_DEFAULT)],
];

function getDemoData(): array
{
    static $data;
    if ($data) {
        return $data;
    }

    $courses = [];
    $courseNames = ['BCA', 'BBA', 'MBA', 'B.Com', 'M.Com', 'MCA', 'B.Tech CSE', 'B.Tech ECE', 'BA English', 'B.Sc Math'];
    for ($i = 1; $i <= 25; $i++) {
        $courses[] = [
            'id' => $i,
            'name' => $courseNames[$i % count($courseNames)] . ' ' . ceil($i / 10),
            'duration' => ($i % 3) + 2 . ' Years',
            'seats' => rand(40, 180),
            'fee' => rand(60000, 220000),
        ];
    }

    $students = [];
    for ($i = 1; $i <= 500; $i++) {
        $feeTotal = rand(70000, 200000);
        $paid = rand(30000, $feeTotal);
        $students[] = [
            'id' => 10000 + $i,
            'name' => 'Student ' . $i,
            'email' => "student{$i}@college.edu",
            'course' => $courses[$i % 25]['name'],
            'semester' => rand(1, 8),
            'attendance' => rand(68, 98),
            'fee_total' => $feeTotal,
            'fee_paid' => $paid,
        ];
    }

    $faculty = [];
    for ($i = 1; $i <= 40; $i++) {
        $faculty[] = [
            'id' => 500 + $i,
            'name' => 'Faculty ' . $i,
            'department' => ['Science', 'Commerce', 'Arts', 'Engineering', 'Management'][$i % 5],
            'experience' => rand(2, 18) . ' years',
            'salary' => rand(42000, 120000),
        ];
    }

    $books = [];
    for ($i = 1; $i <= 300; $i++) {
        $books[] = ['id' => 'BK' . str_pad((string) $i, 4, '0', STR_PAD_LEFT), 'title' => 'Library Book ' . $i, 'author' => 'Author ' . $i, 'status' => $i % 6 === 0 ? 'Issued' : 'Available'];
    }

    $hostelRooms = [];
    for ($i = 1; $i <= 20; $i++) {
        $hostelRooms[] = ['room' => 'H-' . str_pad((string) $i, 3, '0', STR_PAD_LEFT), 'capacity' => 3, 'occupied' => rand(0, 3), 'warden' => 'Warden ' . $i];
    }

    $pendingFees = [];
    for ($i = 1; $i <= 150; $i++) {
        $pendingFees[] = ['student' => 'Student ' . rand(1, 500), 'due' => rand(5000, 55000), 'date' => date('Y-m-d', strtotime('+' . rand(1, 40) . ' days'))];
    }

    $data = compact('courses', 'students', 'faculty', 'books', 'hostelRooms', 'pendingFees');
    return $data;
}
