<?php
if (isDirector()) {
    redirect('dashboard.php');
}

$user_id = $_SESSION['user_id'];

// Handle task completion
if (isset($_GET['complete_task'])) {
    $task_id = intval($_GET['complete_task']);
    $stmt = $conn->prepare("UPDATE tasks SET status = 'done', completed_at = NOW() WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
    $stmt->close();
    redirect('dashboard.php');
}

// Get employee info
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$employee = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get employee tasks
$stmt = $conn->prepare("SELECT * FROM tasks WHERE assigned_to = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tasks_result = $stmt->get_result();
$stmt->close();

// Get employee absences
$stmt = $conn->prepare("SELECT * FROM absences WHERE user_id = ? ORDER BY absence_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$absences_result = $stmt->get_result();
$stmt->close();

// Count tasks
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE assigned_to = ? AND status = 'pending'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$pending_tasks = $stmt->get_result()->fetch_assoc()['count'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE assigned_to = ? AND status = 'done'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$completed_tasks = $stmt->get_result()->fetch_assoc()['count'];
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
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
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            color: #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 32px;
            margin: 0 auto;
        }
        .task-card {
            border-left: 4px solid #ffc107;
            transition: all 0.3s;
        }
        .task-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .task-card.completed {
            border-left-color: #28a745;
            opacity: 0.7;
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
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['username']); ?> (Employee)
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
                <div class="mb-4 text-center">
                    <div class="avatar-circle mb-3">
                        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                    </div>
                    <h6><?php echo htmlspecialchars($_SESSION['username']); ?></h6>
                    <small>Employee</small>
                </div>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white active" href="#overview" data-bs-toggle="tab">
                            <i class="bi bi-speedometer2"></i> Overview
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#tasks" data-bs-toggle="tab">
                            <i class="bi bi-list-check"></i> My Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#absences" data-bs-toggle="tab">
                            <i class="bi bi-calendar-x"></i> Absences
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
                <h2 class="mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                
                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview">
                        <!-- Stats -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card stat-card">
                                    <div class="card-body">
                                        <h6 class="text-muted">Current Salary</h6>
                                        <h3 class="text-success">$<?php echo number_format($employee['salary'], 2); ?></h3>
                                        <?php if ($absences_result->num_rows > 0): ?>
                                            <small class="text-muted">Reduced by <?php echo $absences_result->num_rows * 10; ?>% due to absences</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card stat-card">
                                    <div class="card-body">
                                        <h6 class="text-muted">Pending Tasks</h6>
                                        <h3 class="text-warning"><?php echo $pending_tasks; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card stat-card">
                                    <div class="card-body">
                                        <h6 class="text-muted">Completed Tasks</h6>
                                        <h3 class="text-success"><?php echo $completed_tasks; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="bi bi-person-badge"></i> My Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Email:</strong> <?php echo htmlspecialchars($employee['email']); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($employee['phone']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Tab -->
                    <div class="tab-pane fade" id="tasks">
                        <h4 class="mb-4">My Tasks</h4>
                        
                        <div class="row">
                            <?php 
                            $tasks_result->data_seek(0);
                            if ($tasks_result->num_rows === 0): 
                            ?>
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle"></i> No tasks assigned yet.
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php while ($task = $tasks_result->fetch_assoc()): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card task-card <?php echo $task['status'] === 'done' ? 'completed' : ''; ?>">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                                                    <?php if ($task['status'] === 'done'): ?>
                                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Done</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning"><i class="bi bi-clock"></i> Pending</span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="card-text text-muted"><?php echo htmlspecialchars($task['description']); ?></p>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar"></i> Created: <?php echo date('M d, Y', strtotime($task['created_at'])); ?>
                                                </small>
                                                <?php if ($task['status'] === 'pending'): ?>
                                                    <div class="mt-3">
                                                        <a href="?complete_task=<?php echo $task['id']; ?>" class="btn btn-success btn-sm">
                                                            <i class="bi bi-check-circle"></i> Mark as Done
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="mt-2">
                                                        <small class="text-success">
                                                            <i class="bi bi-check-circle-fill"></i> Completed: <?php echo date('M d, Y', strtotime($task['completed_at'])); ?>
                                                        </small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Absences Tab -->
                    <div class="tab-pane fade" id="absences">
                        <h4 class="mb-4">My Absences</h4>
                        
                        <?php if ($absences_result->num_rows > 0): ?>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> 
                                You have <?php echo $absences_result->num_rows; ?> absence(s). Each absence reduces your salary by 10%.
                            </div>
                        <?php endif; ?>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Recorded On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $absences_result->data_seek(0);
                                    if ($absences_result->num_rows === 0): 
                                    ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No absences recorded</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php while ($absence = $absences_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo date('M d, Y', strtotime($absence['absence_date'])); ?></td>
                                                <td><?php echo htmlspecialchars($absence['reason']); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($absence['created_at'])); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
