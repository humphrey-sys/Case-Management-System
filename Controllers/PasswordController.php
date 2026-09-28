<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class PasswordController extends Controller
{

    public function processReset()
{
    $email = $this->request->getPost('email');
    $userModel = new UserModel();

    $user = $userModel->where('email', $email)->first();

    if ($user) {
        // Generate a secure reset token
        $token = bin2hex(random_bytes(32));

        // Save the token and expiration in the database
        $userModel->update($user['id'], [
            'reset_token' => $token,
            'reset_token_expiry' => date('Y-m-d H:i:s', strtotime('+1 hour')),
        ]);

        // Send reset link to the user's email using CodeIgniter Email Library
        $emailService = \Config\Services::email();

        $emailService->setTo($email);
        $emailService->setSubject('Password Reset');
        $resetLink = base_url("password/reset/$token");
        $emailService->setMessage(
            "Dear {$user['name']},<br><br>" .
            "We received a request to reset your password.<br>" .
            "Click the link below to reset your password:<br>" .
            "<a href=\"$resetLink\">$resetLink</a><br><br>" .
            "If you did not request this, please ignore this email.<br><br>" .
            "Regards,<br>Your Application Team"
        );

        if ($emailService->send()) {
            return redirect()->to('/login')->with('resetMessage', 'Password reset link sent to your email.');
        } else {
            log_message('error', $emailService->printDebugger(['headers']));
            return redirect()->to('/login')->with('resetMessage', 'Failed to send the email. Please try again later.');
        }
    }

    return redirect()->to('/login')->with('resetMessage', 'Email not found.');
}


    public function showResetPasswordForm($token)
    {
        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)
                          ->where('reset_token_expiry >=', date('Y-m-d H:i:s'))
                          ->first();

        if ($user) {
            return view('reset_password_form', ['token' => $token]); // View for entering new password
        }

        return redirect()->to('/password/reset')->with('error', 'Invalid or expired token.');
    }

    public function updatePassword()
{
    $token = $this->request->getPost('token');
    $newPassword = $this->request->getPost('password');
    $confirmPassword = $this->request->getPost('confirm_password');

    if ($newPassword !== $confirmPassword) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Passwords do not match.'
        ]);
    }

    $userModel = new UserModel();
    $user = $userModel->where('reset_token', $token)
                      ->where('reset_token_expiry >=', date('Y-m-d H:i:s'))
                      ->first();

    if ($user) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $userModel->update($user['id'], [
            'password' => $hashedPassword,
            'reset_token' => null, // Clear the token
            'reset_token_expiry' => null,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Password updated successfully.'
        ]);
    }

    return $this->response->setJSON([
        'success' => false,
        'message' => 'Invalid or expired token.'
    ]);
}

}
