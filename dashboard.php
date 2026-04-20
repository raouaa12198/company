<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('index.php');
}

// Redirect based on role
if (isDirector()) {
    include 'director_dashboard.php';
} else {
    include 'employee_dashboard.php';
}
?>
