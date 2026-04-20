<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, username, password, role, email FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['email'] = $user['email'];
                
                redirect('dashboard.php');
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username or password';
        }
        $stmt->close();
    } else {
        $error = 'Please fill in all fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login -Same info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .navbar {
            background: linear-gradient(135deg, #0f38ec 0%, #f50e0e 100%);
        }
        body {
            background: linear-gradient(135deg, #0f38ec 0%, #f50e0e 100%);
            min-height: 100vh;
            padding-top: 80px;
        }
        .main-content {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 80px);
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .login-side {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
        }
        .login-form-side {
            padding: 60px 40px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fs-4 fw-bold" href="home.php">
                <i class="bi bi-code-square"></i> Same-Info
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
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
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-person-lock"></i> Portail des employés
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="login-card">
                    <div class="row g-0">
                        <div class="col-lg-6 login-side d-flex flex-column justify-content-center">
                            <h1 class="mb-4"><i class="bi bi-building"></i> Same info</h1>
                            <p class="lead">Gérez efficacement votre équipe, vos tâches et vos performances.</p>
                        </div>
                        <div class="col-lg-6 login-form-side">
                            <h2 class="mb-4">Bienvenue</h2>
                            
                            <?php if ($error): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>
                            
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="username" class="form-label">nom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </button>
                            </form>
                            
                            <div class="text-center mb-3">
                                <a href="forgot_password.php" class="text-decoration-none">
                                    <i class="bi bi-key"></i> Mot de Passe Oublié?
                                </a>
                            </div>
                            
                            <div class="text-center">
                                <small class="text-muted">pas de compte? <a href="register.php">inscrivez-vous ici</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
