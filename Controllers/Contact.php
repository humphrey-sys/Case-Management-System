<?php

namespace App\Controllers;

use App\Models\UserModel;

class Contact extends BaseController
{
   public function send()
{
    $name = $this->request->getPost('name');
    $email = $this->request->getPost('email');
    $message = $this->request->getPost('message');

    $userModel = new UserModel();
    $superadmin = $userModel->where('role', 'superadmin')->first();

    if (!$superadmin || !isset($superadmin['email'])) {
        return redirect()->back()->with('error', 'Superadmin email not found.');
    }

    $to = $superadmin['email'];
    $subject = 'New Contact Form Message';
    $body = "Name: $name\nEmail: $email\nMessage:\n$message"; // Keep as plain text

    $emailService = \Config\Services::email();

    $emailService->setTo($to);
    $emailService->setFrom('no-reply@yourdomain.com', 'CMS Contact Form');
    $emailService->setSubject($subject);
    $emailService->setMessage($body); // No nl2br here

    if (!$emailService->send()) {
        // Print debug info for testing
        echo "<pre>";
        print_r($emailService->printDebugger(['headers', 'subject', 'body']));
        echo "</pre>";
        exit; // Stop execution to see the output
    }

    return redirect()->back()->with('success', 'Message sent successfully!');
}
}