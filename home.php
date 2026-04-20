<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Same-Info - Société de développement Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #ef160b;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 1rem 0;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        
        .service-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            height: 100%;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 12px rgba(0,0,0,0.2);
        }
        
        .service-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .about-section {
            background-color: #117be5;
            padding: 80px 0;
        }
        
        .contact-section {
            padding: 80px 0;
        }
        
        .contact-info {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            height: 100%;
        }
        
        .contact-info i {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        footer {
            background: #2c3e50;
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }
        
        .btn-employee-portal {
            background: white;
            color: var(--primary-color);
            border: 2px solid white;
            font-weight: bold;
        }
        
        .btn-employee-portal:hover {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fs-4 fw-bold" href="#home">
                <i class="bi bi-code-square"></i> Same-Info
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-employee-portal" href="index.php">
                            <i class="bi bi-person-lock"></i> Portail des employés
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">Bienvenue dans Same-Info</h1>
            <p class="lead fs-4 mb-4">Votre partenaire de confiance en excellence du développement web</p>
            <p class="fs-5">Transformer les idées en réalité numérique</p>
            <div class="mt-5">
                <a href="#services" class="btn btn-light btn-lg me-3">
                    <i class="bi bi-rocket"></i> nos Services
                </a>
                <a href="#contact" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-envelope"></i> Contactez_nous
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="display-5 fw-bold mb-4">About Same-Info</h2>
                    <p class="lead">Nous sommes une entreprise leader en développement web, spécialisée dans la création de solutions numériques innovantes qui stimulent la croissance des entreprises..</p>
                    <p>Fondée avec la vision de fournir des technologies web de pointe, Same-Info est à l'avant-garde de la transformation numérique. Notre équipe d'experts en développement, design et stratégie travaille en collaboration pour donner vie à votre vision..</p>
                    <p class="fw-bold text-primary">Notre mission : Donner aux entreprises les moyens de dépasser leurs attentes grâce à des solutions web innovantes.</p>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">Pourquoi nous?</h4>
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Équipe d'experts développeurs</li>
                                <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Technologies et frameworks modernes</li>
                                <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Conception réactive et axée sur les mobiles</li>
                                <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Livraison du projet dans les délais impartis</li>
                                <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Assistance technique 24h/24 et 7j/7</li>
                                <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i> Prix compétitifs</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">nos Services</h2>
                <p class="lead text-muted">Solutions complètes de développement Web</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-palette service-icon"></i>
                            <h4 class="card-title mb-3">Conception de sites Web</h4>
                            <p class="card-text">Des interfaces élégantes et intuitives qui captivent votre public et optimisent l'expérience utilisateur. Des designs personnalisés, parfaitement adaptés à votre identité de marque..</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-code-slash service-icon"></i>
                            <h4 class="card-title mb-3">Développement Web</h4>
                            <p class="card-text">Développement full-stack utilisant des technologies de pointe comme PHP, Laravel, React et Node.js. Applications web évolutives et sécurisées.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-phone service-icon"></i>
                            <h4 class="card-title mb-3">Conception réactive</h4>
                            <p class="card-text">Sites web responsifs, conçus pour les mobiles, qui fonctionnent parfaitement sur tous les appareils et toutes les tailles d'écran. Optimisés pour la performance et la vitesse..</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-cart service-icon"></i>
                            <h4 class="card-title mb-3">E-Commerce Solutions</h4>
                            <p class="card-text">Plateformes e-commerce complètes avec intégration des paiements, gestion des stocks et expériences d'achat conviviales.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-search service-icon"></i>
                            <h4 class="card-title mb-3">SEO Optimisation </h4>
                            <p class="card-text">Optimisation pour les moteurs de recherche afin d'améliorer la visibilité et le classement de votre site web sur Google et autres moteurs de recherche..</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-tools service-icon"></i>
                            <h4 class="card-title mb-3">Entretien et assistance</h4>
                            <p class="card-text">Assistance technique continue, mises à jour et maintenance pour assurer le bon fonctionnement et la sécurité de votre site web.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Contactez-Nous</h2>
                <p class="lead text-muted">Contactez notre équipe</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="contact-info text-center">
                        <i class="bi bi-geo-alt"></i>
                        <h5 class="mt-3">Notre bureau</h5>
                        <p>rue liberté<br>Tunis, Tunisia 1002</p>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="contact-info text-center">
                        <i class="bi bi-telephone"></i>
                        <h5 class="mt-3">telePhone</h5>
                        <p>+216 12 345 678<br>+216 98 765 432</p>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="contact-info text-center">
                        <i class="bi bi-envelope"></i>
                        <h5 class="mt-3">Email</h5>
                        <p><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="b4d7dbdac0d5d7c0f4c7d5d9d199dddad2db9ad7dbd9">[email&#160;protected]</a><br><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="8bf8fefbfbe4f9ffcbf8eae6eea6e2e5ede4a5e8e4e6">[email&#160;protected]</a></p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">Envoyez-nous un message</h4>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Votre nom</label>
                                        <input type="text" class="form-control" placeholder="nom" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Votre Email</label>
                                        <input type="email" class="form-control" placeholder="tonemail@gmail.com" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Subject</label>
                                        <input type="text" class="form-control" placeholder="How can we help?" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control" rows="5" placeholder="Your message here..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="bi bi-send"></i> Envoyer un message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5><i class="bi bi-code-square"></i> Same-Info</h5>
                    <p class="text-white-50">Votre partenaire de confiance pour l'excellence en développement web.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-white-50 text-decoration-none">Accueil</a></li>
                        <li><a href="#about" class="text-white-50 text-decoration-none">À propos</a></li>
                        <li><a href="#services" class="text-white-50 text-decoration-none">Services</a></li>
                        <li><a href="#contact" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Suivez-nous</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-white">
            <div class="text-center">
                <p class="mb-0">&copy; 2026 Same-Info. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.p