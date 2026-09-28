<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Home</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />

    <style>
        /* Reset & Base */
        *, *::before, *::after {
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background: #f5faff; /* White with slight blue tint */
            color: #0a58ca; /* Primary blue for text */
            transition: background 0.3s ease;
            font-size: 1.1rem; /* Slightly larger base font size */
            line-height: 1.7; /* Increased line height for readability */
            letter-spacing: 0.02em; /* Subtle letter spacing */
        }

        /* Neumorphic Shadow Classes */
        .neumorphic {
            background: #f5faff;
            border-radius: 20px;
            box-shadow: 6px 6px 12px rgba(10, 88, 202, 0.2),
                        -6px -6px 12px rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .neumorphic-inset {
            background: #f5faff;
            border-radius: 20px;
            box-shadow: inset 4px 4px 8px rgba(10, 88, 202, 0.2),
                        inset -4px -4px 8px rgba(255, 255, 255, 0.9);
        }

        .neumorphic:hover {
            transform: translateY(-2px);
            box-shadow: 8px 8px 16px rgba(10, 88, 202, 0.3),
                        -8px -8px 16px rgba(255, 255, 255, 1);
        }

        /* Navbar */
        .navbar {
            background: #f5faff !important;
            box-shadow: 6px 6px 12px rgba(10, 88, 202, 0.2),
                        -6px -6px 12px rgba(255, 255, 255, 0.9);
            padding: 0.75rem 1rem;
            border-radius: 0 0 15px 15px;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem; /* Larger for clarity */
            color: #0a58ca !important;
            text-shadow: 1px 1px 2px rgba(10, 88, 202, 0.2);
        }
        .navbar-nav .nav-link {
            color: #0a58ca !important;
            font-weight: 500;
            font-size: 1.15rem; /* Larger font size */
            padding: 0.5rem 1.2rem;
            border-radius: 15px;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            background: #f5faff;
            box-shadow: inset 3px 3px 6px rgba(10, 88, 202, 0.2),
                        inset -3px -3px 6px rgba(255, 255, 255, 0.9);
            color: #003087 !important;
            transform: scale(0.98);
        }
        .navbar-toggler {
            border: none;
            background: #f5faff;
            box-shadow: 4px 4px 8px rgba(10, 88, 202, 0.2),
                        -4px -4px 8px rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 0.5rem;
        }
        .navbar-toggler:focus {
            box-shadow: inset 3 prestaçãopx 3px 6px rgba(10, 88, 202, 0.2),
                        inset -3px -3px 6px rgba(255, 255, 255, 0.9);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(245, 250, 255, 0.9), rgba(255, 255, 255, 0.7)),
                        url('https://via.placeholder.com/1920x900') center center/cover no-repeat;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #0a58ca;
            padding: 0 1.5rem;
            box-shadow: inset 6px 6px 12px rgba(10, 88, 202, 0.15),
                        inset -6px -6px 12px rgba(255, 255, 255, 0.7);
        }
        .hero h1 {
            font-weight: 700;
            font-size: clamp(2.25rem, 5vw, 4rem); /* Larger for clarity */
            text-shadow: 1px 1px 3px rgba(10, 88, 202, 0.2);
            margin-bottom: 0.5rem;
        }
        .hero h2 {
            font-weight: 600;
            font-size: clamp(1.75rem, 3.5vw, 2.5rem);
            color: #004aad;
            margin-top: 0.5rem;
        }
        .hero p {
            font-weight: 500;
            font-size: clamp(1.15rem, 2.5vw, 1.75rem);
            color: #0a58ca;
            margin-bottom: 2rem;
        }
        .btn-cta {
            font-size: 1.3rem; /* Larger for readability */
            font-weight: 600;
            padding: 0.8rem 2.5rem;
            border-radius: 25px;
            background: #f5faff;
            color: #0a58ca;
            border: none;
            box-shadow: 6px 6px 12px rgba(10, 88, 202, 0.2),
                        -6px -6px 12px rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }
        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 8px 8px 16px rgba(10, 88, 202, 0.3),
                        -8px -8px 16px rgba(255, 255, 255, 1);
            color: #003087;
        }
        .btn-cta:focus {
            box-shadow: inset 4px 4px 8px rgba(10, 88, 202, 0.2),
                        inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            transform: scale(0.98);
        }

        /* Features Section */
        .features {
            background: #f5faff;
            padding: 5rem 2rem;
        }
        .features h2 {
            font-weight: 700;
            font-size: 2.75rem; /* Larger for clarity */
            margin-bottom: 3rem;
            color: #0a58ca;
            text-shadow: 1px 1px 2px rgba(10, 88, 202, 0.2);
        }
        .feature-card {
            background: #f5faff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 6px 6px 12px rgba(10, 88, 202, 0.2),
                        -6px -6px 12px rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 8px 8px 16px rgba(10, 88, 202, 0.3),
                        -8px -8px 16px rgba(255, 255, 255, 1);
        }
        .feature-icon {
            font-size: 3.75rem; /* Slightly larger */
            color: #0a58ca;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }
        .feature-card h5 {
            font-weight: 600;
            font-size: 1.35rem; /* Larger for clarity */
            color: #0a58ca;
            margin-bottom: 0.75rem;
        }
        .feature-card p {
            font-weight: 500;
            font-size: 1.1rem;
            color: #0a58ca;
        }

        /* About Section */
        .about {
            background: #f5faff;
            padding: 4rem 2rem;
            text-align: center;
        }
        .about h2 {
            font-weight: 700;
            font-size: 2.75rem;
            color: #0a58ca;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(10, 88, 202, 0.2);
        }
        .about p {
            font-weight: 500;
            font-size: 1.2rem; /* Larger for clarity */
            color: #0a58ca;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Contact Section */
        .contact {
            background: #f5faff;
            padding: 4rem 2rem;
            text-align: center;
        }
        .contact h2 {
            font-weight: 700;
            font-size: 2.75rem;
            color: #0a58ca;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(10, 88, 202, 0.2);
        }
        .contact p {
            font-weight: 500;
            font-size: 1.2rem;
            color: #0a58ca;
            margin-bottom: 2rem;
        }
        .contact .form-control {
            border-radius: 15px;
            background: #f5faff;
            border: none;
            box-shadow: inset 4px 4px 8px rgba(10, 88, 202, 0.2),
                        inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: 500;
            color: #0a58ca;
        }
        .contact .form-control:focus {
            box-shadow: 4px 4px 8px rgba(10, 88, 202, 0.2),
                        -4px -4px 8px rgba(255, 255, 255, 0.9);
            outline: none;
        }
        .contact .btn {
            border-radius: 15px;
            background: #f5faff;
            color: #0a58ca;
            box-shadow: 6px 6px 12px rgba(10, 88, 202, 0.2),
                        -6px -6px 12px rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .contact .btn:hover {
            transform: translateY(-2px);
            box-shadow: 8px 8px 16px rgba(10, 88, 202, 0.3),
                        -8px -8px 16px rgba(255, 255, 255, 1);
            color: #003087;
        }
        .contact .btn:focus {
            box-shadow: inset 4px 4px 8px rgba(10, 88, 202, 0.2),
                        inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            transform: scale(0.98);
        }

        /* Login Modal */
        .modal-content {
            background: #f5faff;
            border-radius: 20px;
            box-shadow: 8px 8px 16px rgba(10, 88, 202, 0.3),
                        -8px -8px 16px rgba(255, 255, 255, 1);
            border: none;
        }
        .modal-header, .modal-body, .modal-footer {
            background: #f5faff;
            border: none;
        }
        .modal .form-control {
            background: #f5faff;
            border-radius: 15px;
            border: none;
            box-shadow: inset 4px 4px 8px rgba(10, 88, 202, 0.2),
                        inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: 500;
            color: #0a58ca;
        }
        .modal .form-control:focus {
            box-shadow: 4px 4px 8px rgba(10, 88, 202, 0.2),
                        -4px -4px 8px rgba(255, 255, 255, 0.9);
            outline: none;
        }
        .modal .btn-primary {
            background: #f5faff;
            color: #0a58ca;
            border: none;
            box-shadow: 6px 6px 12px rgba(10, 88, 202, 0.2),
                        -6px -6px 12px rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .modal .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 8px 8px 16px rgba(10, 88, 202, 0.3),
                        -8px -8px 16px rgba(255, 255, 255, 1);
            color: #003087;
        }
        .modal .btn-primary:focus {
            box-shadow: inset 4px 4px 8px rgba(10, 88, 202, 0.2),
                        inset -4px -4Walletpx 8px rgba(255, 255, 255, 0.9);
            transform: scale(0.98);
        }

        /* Footer */
        footer {
            background: #e6ecf0; /* Off-white for contrast */
            color: #0a58ca;
            padding: 2rem 0;
            box-shadow: inset 6px 6px 12px rgba(10, 88, 202, 0.15),
                        inset -6px -6px 12px rgba(255, 255, 255, 0.7);
        }
        footer a {
            color: #0a58ca;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        footer a:hover {
            color: #003087;
        }
        footer .btn-outline-light {
            background: #f5faff;
            color: #0a58ca;
            border: none;
            box-shadow: 4px 4px 8px rgba(10, 88, 202, 0.2),
                        -4px -4px 8px rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: 500;
        }
        footer .btn-outline-light:hover {
            box-shadow: inset 3px 3px 6px rgba(10, 88, 202, 0.2),
                        inset -3px -3px 6px rgba(255, 255, 255, 0.9);
            color: #003087;
            transform: scale(0.98);
        }
        footer .bi {
            color: #0a58ca;
            font-size: 1.5rem; /* Larger for clarity */
            transition: transform 0.3s ease;
        }
        footer .bi:hover {
            transform: scale(1.2);
        }

        /* Accessibility Enhancements */
        @media (prefers-contrast: high) {
            body {
                background: #ffffff;
            }
            .neumorphic, .neumorphic-inset, .navbar, .hero, .features, .contact, footer {
                background: #ffffff;
                box-shadow: none;
                border: 1px solid #0a58ca;
            }
            .navbar-nav .nav-link, .btn-cta, .contact .btn, .modal .btn-primary, footer .btn-outline-light {
                background: #0a58ca;
                color: #ffffff !important;
                box-shadow: none;
            }
            .feature-card p, .about p, .contact p {
                color: #000000 !important;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            body {
                background: #1a2a44;
                color: #e6ecf0;
            }
            .neumorphic, .neumorphic-inset, .navbar, .hero, .features, .contact, .modal-content {
                background: #1a2a44;
                box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.5),
                            -6px -6px 12px rgba(40, 60, 100, 0.5);
            }
            .neumorphic-inset {
                box-shadow: inset 4px 4px 8px rgba(0, 0, 0, 0.5),
                            inset -4px -4px 8px rgba(40, 60, 100, 0.5);
            }
            .navbar-brand, .navbar-nav .nav-link, .hero h1, .hero h2, .hero p, .features h2, .contact h2, .about h2, .feature-card h5, .feature-card p, .contact p {
                color: #e6ecf0 !important;
            }
            .btn-cta, .contact .btn, .modal .btn-primary, footer .btn-outline-light {
                color: #80b3ff;
                background: #1a2a44;
                box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.5),
                            -6px -6px 12px rgba(40, 60, 100, 0.5);
            }
            footer {
                background: #152238;
            }
            footer .bi {
                color: #80b3ff;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg shadow fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">CASE MANAGEMENT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link neumorphic" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link neumorphic" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link neumorphic" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link neumorphic" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content neumorphic">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control neumorphic-inset" id="email" placeholder="Enter your email" required />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control neumorphic-inset" id="password" placeholder="Enter your password" required />
                        </div>
                        <button type="submit" class="btn btn-primary w-100 neumorphic">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero neumorphic" id="hero">
        <h1>Welcome to Our Case Management System</h1>
        <h2>Manage Cases Efficiently</h2>
        <p>Streamline your workflow and achieve better results with our system.</p>
        <a href="/login" class="btn btn-primary mt-4 btn-cta">CLICK HERE TO LOGIN</a>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <h2>About Us</h2>
        <p>
            Our Case Management System is designed to simplify and enhance case handling within your organization. 
            With powerful tools for tracking, managing, and collaborating on cases, we ensure that your team operates 
            efficiently while maintaining accountability.
        </p>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container text-center">
            <h2>Our Features</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card p-4 neumorphic">
                        <div class="feature-icon"><i class="bi bi-person"></i></div>
                        <h5>User Management</h5>
                        <p>Easily manage user roles and permissions with our system.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card p-4 neumorphic">
                        <div class="feature-icon"><i class="bi bi-clipboard-data"></i></div>
                        <h5>Case Tracking</h5>
                        <p>Track cases in real-time with detailed reporting and updates.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card p-4 neumorphic">
                        <div class="feature-icon"><i class="bi bi-chat-dots"></i></div>
                        <h5>Collaboration</h5>
                        <p>Improve teamwork and communication with built-in tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <h2>Contact Us</h2>
        <p>We’d love to hear from you! Fill out the form below to get in touch with us.</p>
        <div class="container">
            <!-- Flash messages for success/error -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show neumorphic" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show neumorphic" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('contact/send') ?>" method="post">
                <input type="text" class="form-control mb-2 neumorphic-inset" name="name" placeholder="Your Name" required />
                <input type="email" class="form-control mb-2 neumorphic-inset" name="email" placeholder="Your Email" required />
                <textarea class="form-control mb-2 neumorphic-inset" name="message" placeholder="Your Message" rows="4" required></textarea>
                <button type="submit" class="btn btn-primary mt-3 neumorphic">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row gy-4">
                <!-- Quick Links -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-uppercase fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li>
                            <a href="#hero" class="btn btn-outline-light btn-sm w-100 text-start neumorphic">Home</a>
                        </li>
                        <li>
                            <a href="#about" class="btn btn-outline-light btn-sm w-100 text-start neumorphic">About</a>
                        </li>
                        <li>
                            <a href="#features" class="btn btn-outline-light btn-sm w-100 text-start neumorphic">Features</a>
                        </li>
                        <li>
                            <a href="#contact" class="btn btn-outline-light btn-sm w-100 text-start neumorphic">Contact</a>
                        </li>
                        <li>
                            <a href="/login" class="btn btn-outline-light btn-sm w-100 text-start neumorphic">Login</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Information -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-uppercase fw-bold mb-3">Contact Us</h5>
                    <p class="mb-1"><i class="bi bi-envelope me-2"></i>info@casesystem.com</p>
                    <p class="mb-1"><i class="bi bi-phone me-2"></i>+254 759 932 125</p>
                    <p><i class="bi bi-geo-alt me-2"></i>123 PC Offices, Nakuru, Kenya</p>
                </div>

                <!-- Follow Us -->
                <div class="col-lg-4 col-md-12">
                    <h5 class="text-uppercase fw-bold mb-3">Follow Us</h5>
                    <div>
                        <a href="#" class="me-3 fs-4 neumorphic" style="padding: 12px; display: inline-block;"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="me-3 fs-4 neumorphic" style="padding: 12px; display: inline-block;"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="me-3 fs-4 neumorphic" style="padding: 12px; display: inline-block;"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="fs-4 neumorphic" style="padding: 12px; display: inline-block;"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <hr class="my-4 border-light">

            <!-- Copyright Section -->
            <div class="text-center">
                <p class="mb-0">© 2025 Case Management System. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>