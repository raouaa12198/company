<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = $_POST['role'] ?? 'employee';
    
    // Validate role
    if (!in_array($role, ['director', 'employee'])) {
        $role = 'employee';
    }
    
    if (!empty($username) && !empty($password) && !empty($email)) {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = 'Username already exists';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user with selected role
            $stmt = $conn->prepare("INSERT INTO users (username, password, role, email, phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $hashed_password, $role, $email, $phone);
            
            if ($stmt->execute()) {
                $success = 'Account created successfully! You can now login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
        $stmt->close();
    } else {
        $error = 'Please fill in all required fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrivez-vous - Same info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .navbar {
            background: linear-gradient(135deg, #0e37ef 0%, #ed0a0a 100%);
        }
        body {
            background: linear-gradient(135deg, #0e37ef 0%, #ed0a0a 100%);
            min-height: 100vh;
            padding-top: 80px;
        }
        .main-content {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 500px;
            width: 100%;
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
            <div class="col-lg-6">
                <div class="register-card">
                    <h2 class="mb-4 text-center"><i class="bi bi-person-plus"></i> Creer un compte</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="role" class="form-label">Inscrivez-vous en tant que *</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="employee">Employe</option>
                                <option value="director">Directeur</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telephone</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe *</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-person-check"></i>Inscrivez-vous
                        </button>
                    </form>
                    
                    <div class="text-center">
                        <small class="text-muted">Vous avez déjà un compte ? <a href="index.php">Connectez-vous ici</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
