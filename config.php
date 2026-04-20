<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'company_stage');

// Create database connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Helper function to check if user is director
function isDirector() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'director';
}

// Helper function to redirect
function redirect($page) {
    header("Location: $page");
    exit();
}
?>
