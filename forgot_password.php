<?php
require_once 'config.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    if (!empty($email)) {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id, username FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            // Generate a random temporary password
            $temp_password = bin2hex(random_bytes(4)); // 8 character password
            $hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);
            
            // Update password in database
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed_password, $user['id']);
            $stmt->execute();
            
            // In a real application, you would send this via email
            // For now, we'll display it on screen
            $message = "Password reset successful! Your temporary password is: <strong>$temp_password</strong><br>
                        Username: <strong>{$user['username']}</strong><br>
                        Please login and change your password immediately.<br>
                        <small class='text-muted'>(In production, this would be sent to your email: $email)</small>";
        } else {
            $error = 'No account found with this email address.';
        }
        $stmt->close();
    } else {
        $error = 'Please enter your email address.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - same info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .navbar {
            background: linear-gradient(135deg, #0a36fa 0%, #f90909 100%);
        }
        body {
            background: linear-gradient(135deg, #0a36fa 0%, #f90909 100%);
            min-height: 100vh;
            padding-top: 80px;
        }
        .main-content {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 80px);
        }
        .forgot-card {
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
                <div class="forgot-card">
                    <div class="text-center mb-4">
                        <i class="bi bi-key text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-3">Mot de Passe Oublié?</h2>
                        <p class="text-muted">Saisissez votre adresse e-mail pour réinitialiser votre mot de passe</p>
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($message): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> <?php echo $message; ?>
                        </div>
                        <div class="text-center mt-4">
                            <a href="index.php" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right"></i> Allez dans Connexion
                            </a>
                        </div>
                    <?php else: ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="your@email.com" required>
                                </div>
                                <small class="text-muted">Nous enverrons un mot de passe temporaire à cette adresse e-mail.</small>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-arrow-clockwise"></i> Réinitialiser le mot de passe
                            </button>
                        </form>
                        
                        <div class="text-center">
                            <small class="text-muted">
                                Vous vous souvenez de votre mot de passe ? <a href="index.php">Connectez-vous ici</a>
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
