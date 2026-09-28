<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Reset Password</h2>
            <div id="feedback" class="alert d-none" role="alert"></div>
            <form id="resetPasswordForm">
                <input type="hidden" name="token" value="<?= $token ?>">
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form submission

        const form = e.target;
        const formData = new FormData(form);
        const feedback = document.getElementById('feedback');

        fetch('<?= base_url("password/update") ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            feedback.classList.remove('d-none', 'alert-success', 'alert-danger');
            if (data.success) {
                feedback.classList.add('alert-success');
                feedback.textContent = data.message;

                // Redirect to login after 2 seconds
                setTimeout(() => {
                    window.location.href = '<?= base_url("login") ?>';
                }, 2000);
            } else {
                feedback.classList.add('alert-danger');
                feedback.textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            feedback.classList.remove('d-none', 'alert-success');
            feedback.classList.add('alert-danger');
            feedback.textContent = 'An unexpected error occurred. Please try again.';
        });
    });
</script>
</body>
</html>
