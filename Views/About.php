<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Case Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .hero {
            background-color: #2E3B4E;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }
        .hero p {
            font-size: 1.5rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
        }
        .features-section {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
            transition: transform 0.3s;
        }
        .features-section:hover {
            transform: translateY(-5px);
        }
        .footer {
            background-color: #343a40;
            color: white;
            font-size: 0.9rem;
        }
        .footer p {
            margin: 0;
        }
        .text-highlight {
            color: #0d6efd;
            font-weight: bold;
        }
        .navbar {
            background-color: #0D47A1 !important; /* Updated navbar background color */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="#">CASE MANAGEMENT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div>
            <h1>About Us</h1>
            <p>Your Ultimate Case Management Solution</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row text-center mb-4">
            <div class="col">
                <h2>Welcome to <span class="text-highlight">Case Management System</span></h2>
                <p class="lead">Streamline case handling, boost efficiency, and ensure accountability within your organization.</p>
            </div>
        </div>

        <!-- Features Section -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="features-section">
                    <h4 class="mb-3 text-highlight">Key Features</h4>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Role-based user access for Superadmins, Admins, and Officers</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Efficient case assignment and tracking</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Detailed reports and analytics for decision-making</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Comprehensive dashboards tailored to each role</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="features-section">
                    <h4 class="mb-3 text-highlight">Our Mission</h4>
                    <p>Our mission is to provide an easy-to-use system that simplifies case management, enhances accountability, and improves productivity in organizations of all sizes.</p>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="row mt-4">
            <div class="col">
                <div class="features-section">
                    <h4 class="mb-3 text-highlight">Why Choose Us?</h4>
                    <p>We understand the challenges of managing cases in dynamic environments. That’s why we’ve built a solution that focuses on simplicity, efficiency, and customization. Whether you’re a small team or a large organization, our system can be tailored to meet your needs.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-3">
        <div class="container text-center">
            <p>&copy; 2025 Case Management System. Built with ❤️ by <span class="text-highlight">Your Organization</span>.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
