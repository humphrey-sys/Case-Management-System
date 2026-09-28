<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Case Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #e0e5ec;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #e0e5ec !important;
            box-shadow: inset 3px 3px 7px #babecc, inset -3px -3px 7px #ffffff;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.6rem;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 20px;
            background: #e0e5ec;
            box-shadow: 10px 10px 30px #babecc, -10px -10px 30px #ffffff;
        }

        .form-control, .input-group-text {
            border-radius: 10px;
            background: #e0e5ec;
            box-shadow: inset 5px 5px 10px #babecc, inset -5px -5px 10px #ffffff;
            border: none;
        }

        .form-control:focus {
            box-shadow: inset 2px 2px 5px #babecc, inset -2px -2px 5px #ffffff;
        }

        .btn-primary, .btn-success {
            border: none;
            border-radius: 12px;
            background: #007bff;
            box-shadow: 5px 5px 15px #babecc, -5px -5px 15px #ffffff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover, .btn-success:hover {
            background-color: #0056b3;
            box-shadow: inset 5px 5px 10px #babecc, inset -5px -5px 10px #ffffff;
        }

        .modal-content {
            border-radius: 20px;
            background: #e0e5ec;
            box-shadow: 10px 10px 30px #babecc, -10px -10px 30px #ffffff;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .modal-footer .btn {
            width: 100%;
        }

        .input-group-text {
            cursor: pointer;
        }

        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">CASE MANAGEMENT</a>
        </div>
    </nav>

    <!-- Login Card -->
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4" style="width: 100%; max-width: 420px;">
            <h2 class="text-center mb-4">Login</h2>

            <!-- Flash message -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="<?= base_url('login') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="Enter your email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" required placeholder="Enter your password">
                        <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword"></i></span>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>

            <div class="text-center">
                <small class="text-muted">OTP will be sent to your email for verification.</small><br>
                <a href="#" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">Forgot Password?</a>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div class="modal fade <?= session()->getFlashdata('resetMessage') ? 'show' : '' ?>" id="resetPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php if (session()->getFlashdata('resetMessage')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('resetMessage') ?></div>
                    <?php else: ?>
                        <form method="POST" action="<?= base_url('password/reset') ?>">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="resetEmail" class="form-label">Email Address</label>
                                <input type="email" id="resetEmail" name="email" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Send Reset Link</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- OTP Modal -->
    <div class="modal fade <?= session()->get('otp_needed') ? 'show' : '' ?>" id="otpModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="<?= base_url('verify-otp') ?>">
                <?= csrf_field() ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter OTP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (session()->getFlashdata('otp_error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('otp_error') ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="otp" class="form-label">OTP</label>
                            <input type="text" name="otp" id="otp" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Verify OTP</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="<?= base_url('change-password') ?>">
                <?= csrf_field() ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Default Password</h5>
                    </div>
                    <div class="modal-body">
                        <?php if (session()->getFlashdata('change_error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('change_error') ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            const pwd = document.getElementById("password");
            const icon = this;
            if (pwd.type === "password") {
                pwd.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                pwd.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        });

        // Show modals automatically if needed
        <?php if (session()->get('otp_needed')): ?>
            new bootstrap.Modal(document.getElementById('otpModal')).show();
        <?php session()->remove('otp_needed'); endif; ?>

        <?php if (session()->get('change_password_required')): ?>
            new bootstrap.Modal(document.getElementById('changePasswordModal')).show();
        <?php endif; ?>

        <?php if (session()->getFlashdata('resetMessage')): ?>
            new bootstrap.Modal(document.getElementById('resetPasswordModal')).show();
        <?php endif; ?>
    </script>
</body>
</html>
