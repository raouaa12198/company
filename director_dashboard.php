<?php
if (!isDirector()) {
    redirect('dashboard.php');
}

// Handle employee deletion
if (isset($_GET['delete_employee'])) {
    $employee_id = intval($_GET['delete_employee']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'employee'");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $stmt->close();
    redirect('dashboard.php');
}

// Handle task creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_task'])) {
    $title = trim($_POST['task_title'] ?? '');
    $description = trim($_POST['task_description'] ?? '');
    $assigned_to = intval($_POST['assigned_to'] ?? 0);
    
    if (!empty($title) && $assigned_to > 0) {
        $stmt = $conn->prepare("INSERT INTO tasks (title, description, assigned_to, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $description, $assigned_to, $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle adding new employee
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_employee'])) {
    $username = trim($_POST['new_username'] ?? '');
    $email = trim($_POST['new_email'] ?? '');
    $phone = trim($_POST['new_phone'] ?? '');
    $password = $_POST['new_password'] ?? '';
    $salary = floatval($_POST['new_salary'] ?? 0);
    
    if (!empty($username) && !empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, email, phone, salary) VALUES (?, ?, 'employee', ?, ?, ?)");
        $stmt->bind_param("ssssd", $username, $hashed_password, $email, $phone, $salary);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle salary update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_salary'])) {
    $employee_id = intval($_POST['employee_id'] ?? 0);
    $new_salary = floatval($_POST['salary'] ?? 0);
    
    if ($employee_id > 0) {
        $stmt = $conn->prepare("UPDATE users SET salary = ? WHERE id = ? AND role = 'employee'");
        $stmt->bind_param("di", $new_salary, $employee_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle adding absence
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_absence'])) {
    $employee_id = intval($_POST['absence_employee_id'] ?? 0);
    $absence_date = $_POST['absence_date'] ?? '';
    $reason = trim($_POST['absence_reason'] ?? '');
    
    if ($employee_id > 0 && !empty($absence_date)) {
        $stmt = $conn->prepare("INSERT INTO absences (user_id, absence_date, reason) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $employee_id, $absence_date, $reason);
        $stmt->execute();
        $stmt->close();
        
        // Reduce salary by 10%
        $stmt = $conn->prepare("UPDATE users SET salary = salary * 0.9 WHERE id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Get all employees
$employees_result = $conn->query("SELECT * FROM users WHERE role = 'employee' ORDER BY username");

// Get all tasks
$tasks_result = $conn->query("
    SELECT t.*, u.username as employee_name 
    FROM tasks t 
    JOIN users u ON t.assigned_to = u.id 
    ORDER BY t.created_at DESC
");

// Get completed tasks count
$completed_tasks = $conn->query("SELECT COUNT(*) as count FROM tasks WHERE status = 'done'")->fetch_assoc()['count'];
$total_tasks = $conn->query("SELECT COUNT(*) as count FROM tasks")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Director Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .top-navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 60px;
        }
        .sidebar {
            min-height: calc(100vh - 60px);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            margin-top: 60px;
        }
        .main-content-area {
            margin-top: 60px;
        }
        .stat-card {
            border-left: 4px solid #667eea;
        }
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #667eea;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark top-navbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fs-4 fw-bold" href="home.php">
                <i class="bi bi-code-square"></i> Same-Info
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['username']); ?> (Director)
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-4">
                <h4 class="mb-4"><i class="bi bi-building"></i> Company</h4>
                <div class="mb-4">
                    <div class="avatar-circle mb-2">
                        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                    </div>
                    <h6><?php echo htmlspecialchars($_SESSION['username']); ?></h6>
                    <small>Director</small>
                </div>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white active" href="#employees" data-bs-toggle="tab">
                            <i class="bi bi-people"></i> Employees
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#tasks" data-bs-toggle="tab">
                            <i class="bi bi-list-check"></i> Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="change_password.php">
                            <i class="bi bi-key"></i> Change Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4 main-content-area">
                <h2 class="mb-4">Director Dashboard</h2>
                
                <!-- Stats -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6 class="text-muted">Total Employees</h6>
                                <h3><?php echo $employees_result->num_rows; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6 class="text-muted">Total Tasks</h6>
                                <h3><?php echo $total_tasks; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card">
                            <div class="card-body">
                                <h6 class="text-muted">Completed Tasks</h6>
                                <h3><?php echo $completed_tasks; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Employees Tab -->
                    <div class="tab-pane fade show active" id="employees">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Employees Management</h4>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                                <i class="bi bi-plus-circle"></i> Add Employee
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Salary</th>
                                        <th>Absences</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($employee = $employees_result->fetch_assoc()): ?>
                                        <?php
                                        $absence_count = $conn->query("SELECT COUNT(*) as count FROM absences WHERE user_id = " . $employee['id'])->fetch_assoc()['count'];
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-2" style="width: 30px; height: 30px; font-size: 14px;">
                                                        <?php echo strtoupper(substr($employee['username'], 0, 1)); ?>
                                                    </div>
                                                    <?php echo htmlspecialchars($employee['username']); ?>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($employee['email']); ?></td>
                                            <td><?php echo htmlspecialchars($employee['phone']); ?></td>
                                            <td>$<?php echo number_format($employee['salary'], 2); ?></td>
                                            <td><span class="badge bg-warning"><?php echo $absence_count; ?></span></td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#updateSalaryModal<?php echo $employee['id']; ?>">
                                                    <i class="bi bi-currency-dollar"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#addAbsenceModal<?php echo $employee['id']; ?>">
                                                    <i class="bi bi-calendar-x"></i>
                                                </button>
                                                <a href="?delete_employee=<?php echo $employee['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        
                                        <!-- Update Salary Modal -->
                                        <div class="modal fade" id="updateSalaryModal<?php echo $employee['id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Salary - <?php echo htmlspecialchars($employee['username']); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
                                                            <div class="mb-3">
                                                                <label class="form-label">New Salary</label>
                                                                <input type="number" step="0.01" class="form-control" name="salary" value="<?php echo $employee['salary']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="update_salary" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Add Absence Modal -->
                                        <div class="modal fade" id="addAbsenceModal<?php echo $employee['id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Add Absence - <?php echo htmlspecialchars($employee['username']); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="absence_employee_id" value="<?php echo $employee['id']; ?>">
                                                            <div class="mb-3">
                                                                <label class="form-label">Date</label>
                                                                <input type="date" class="form-control" name="absence_date" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Reason</label>
                                                                <textarea class="form-control" name="absence_reason"></textarea>
                                                            </div>
                                                            <div class="alert alert-warning">
                                                                <small>Note: Adding an absence will reduce salary by 10%</small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="add_absence" class="btn btn-primary">Add Absence</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tasks Tab -->
                    <div class="tab-pane fade" id="tasks">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Tasks Management</h4>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                                <i class="bi bi-plus-circle"></i> Create Task
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Completed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $tasks_result->data_seek(0);
                                    while ($task = $tasks_result->fetch_assoc()): 
                                    ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($task['title']); ?></strong><br>
                                                <small class="text-muted"><?php echo htmlspecialchars($task['description']); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($task['employee_name']); ?></td>
                                            <td>
                                                <?php if ($task['status'] === 'done'): ?>
                                                    <span class="badge bg-success">Done</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($task['created_at'])); ?></td>
                                            <td>
                                                <?php echo $task['completed_at'] ? date('M d, Y', strtotime($task['completed_at'])) : '-'; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="new_username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="new_email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="new_phone">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" step="0.01" class="form-control" name="new_salary" value="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_employee" class="btn btn-primary">Add Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text" class="form-control" name="task_title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="task_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assign To</label>
                            <select class="form-select" name="assigned_to" required>
                                <option value="">Select Employee</option>
                                <?php 
                                $employees_result->data_seek(0);
                                while ($emp = $employees_result->fetch_assoc()): 
                                ?>
                                    <option value="<?php echo $emp['id']; ?>"><?php echo htmlspecialchars($emp['username']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="create_task" class="btn btn-primary">Create Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
