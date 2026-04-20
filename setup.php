<?php
// Database setup script
$host = 'localhost';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS company_stage";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select database
$conn->select_db('company_stage');

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('director', 'employee') NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    salary DECIMAL(10, 2) DEFAULT 0.00,
    avatar VARCHAR(255) DEFAULT 'default_avatar.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Users table created successfully<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create tasks table
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    assigned_to INT NOT NULL,
    created_by INT NOT NULL,
    status ENUM('pending', 'done') DEFAULT 'pending',
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE NO ACTION,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Tasks table created successfully<br>";
} else {
    echo "Error creating tasks table: " . $conn->error . "<br>";
}

// Create absences table
$sql = "CREATE TABLE IF NOT EXISTS absences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    absence_date DATE NOT NULL,
    reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Absences table created successfully<br>";
} else {
    echo "Error creating absences table: " . $conn->error . "<br>";
}

// Insert sample director
$director_password = password_hash('director123', PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO users (username, password, role, email, phone, salary) 
        VALUES ('director', '$director_password', 'director', 'director@company.com', '1234567890', 0.00)";

if ($conn->query($sql) === TRUE) {
    echo "Sample director created successfully<br>";
    echo "<strong>Director Login:</strong><br>";
    echo "Username: director<br>";
    echo "Password: director123<br><br>";
} else {
    echo "Note: Director may already exist<br>";
}

// Insert sample employee
$employee_password = password_hash('employee123', PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO users (username, password, role, email, phone, salary) 
        VALUES ('john_doe', '$employee_password', 'employee', 'john@company.com', '0987654321', 3000.00)";

if ($conn->query($sql) === TRUE) {
    echo "Sample employee created successfully<br>";
    echo "<strong>Employee Login:</strong><br>";
    echo "Username: john_doe<br>";
    echo "Password: employee123<br><br>";
} else {
    echo "Note: Employee may already exist<br>";
}

echo "<br><strong>Setup complete!</strong><br>";
echo "<a href='index.php'>Go to Login Page</a>";

$conn->close();
?>
