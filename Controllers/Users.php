<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Email\Email;

class Users extends ResourceController
{
    public function fetch_users()
    {
        $userModel = new UserModel(); // Ensure you have a UserModel
        $users = $userModel->findAll(); // Fetch all users

        return $this->response->setJSON($users); // Return users in JSON format
    }
  public function fetch_user()
{
    $userModel = new \App\Models\UserModel();

    // Ensure the user is logged in
    if (!session()->get('isLoggedIn')) {
        return $this->response->setJSON(['status' => 401, 'message' => 'Unauthorized. Please log in.']);
    }

    // Get the admin's region from the session
    $adminRegion = session()->get('region');

    if (!$adminRegion) {
        return $this->response->setJSON(['status' => 400, 'message' => 'Region not found in session.']);
    }

    // Fetch users within the same region
    $users = $userModel->where('region', $adminRegion)->findAll();

    return $this->response->setJSON(['status' => 200, 'data' => $users]);
}


    public function getUser($id)
{
    try {
        // Load the User model
        $userModel = new \App\Models\UserModel();
        
        // Find the user by ID
        $user = $userModel->find($id);

        // Check if the user exists
        if (!$user) {
            // Debug: Log or display the ID that is being searched
            log_message('error', "User with ID {$id} not found.");
            return $this->respond([
                'status' => 404,
                'message' => "User with ID {$id} not found."
            ], 404);
        }

        // Return the user data
        return $this->respond([
            'status' => 200,
            'message' => 'User retrieved successfully.',
            'data' => $user
        ], 200);
    } catch (\Exception $e) {
        // Handle any exceptions that occur
        log_message('error', "An error occurred: {$e->getMessage()}");
        return $this->failServerError('An error occurred while retrieving the user: ' . $e->getMessage());
    }
}
public function edit_user($id)
{
    try {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->respond([
                'status' => 404,
                'message' => 'User not found.',
            ], 404);
        }

        return $this->respond([
            'status' => 200,
            'message' => 'User retrieved successfully.',
            'data' => $user,
        ], 200);
    } catch (\Exception $e) {
        return $this->failServerError('An error occurred: ' . $e->getMessage());
    }
}

    // Update user details
public function update_user()
{
    $validationRules = [
        'id' => 'required|integer',
        'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email',
        'county' => 'required|max_length[100]',
        'region' => 'required|max_length[100]',
        'role' => 'required|in_list[superadmin,admin,officer]',
        'status' => 'required|in_list[active,inactive]',
    ];

    if (!$this->validate($validationRules)) {
        return $this->respond([
            'status' => 422,
            'message' => 'Validation failed.',
            'errors' => $this->validator->getErrors(),
        ], 422);
    }

    $userModel = new \App\Models\UserModel();

    $id = $this->request->getPost('id');
    if (!$id || !$userModel->find($id)) {
        return $this->respond([
            'status' => 404,
            'message' => 'User not found.',
        ], 404);
    }

    $data = [
        'name' => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'county' => $this->request->getPost('county'),
        'region' => $this->request->getPost('region'),
        'role' => $this->request->getPost('role'),
        'status' => $this->request->getPost('status'),
    ];

    try {
        $userModel->update($id, $data);
        return $this->respond([
            'status' => 200,
            'message' => 'User updated successfully.',
        ], 200);
    } catch (\Exception $e) {
        return $this->failServerError('Failed to update user: ' . $e->getMessage());
    }
}


    public function delete_user($id)
{
    try {
        $userModel = new \App\Models\UserModel();

        if (!$userModel->find($id)) {
            return $this->respond([
                'status' => 404,
                'message' => 'User not found.',
            ], 404);
        }

        $userModel->delete($id);

        return $this->respond([
            'status' => 200,
            'message' => 'User deleted successfully.',
        ], 200);
    } catch (\Exception $e) {
        return $this->failServerError('An error occurred: ' . $e->getMessage());
    }
}
public function profile()
{
    $userModel = new \App\Models\UserModel();

    // Ensure the user is logged in
    if (!session()->get('isLoggedIn')) {
        return $this->response->setJSON(['status' => 401, 'message' => 'Unauthorized. Please log in.']);
    }

    $userId = session()->get('id');
    $user = $userModel->find($userId);

    if ($user) {
        return $this->response->setJSON(['status' => 200, 'data' => $user]);
    } else {
        return $this->response->setJSON(['status' => 404, 'message' => 'User profile not found.']);
    }
}

public function updateProfile()
{
    $userModel = new UserModel();

    // Get input data
    $userId = $this->request->getPost('userId');
    $data = [
        'name' => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'phone_number' => $this->request->getPost('phone_number'),
        'address' => $this->request->getPost('address'),
        'emergency_contact' => $this->request->getPost('emergency_contact'),
        'gender' => $this->request->getPost('gender'),
        'date_of_birth' => $this->request->getPost('date_of_birth'),
        'region' => $this->request->getPost('region'),
    ];

    // Handle profile picture upload
    $file = $this->request->getFile('profilePicture');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newFileName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newFileName);
        $data['profilePicture'] = $newFileName;
    }

    // Update the user's profile
    if ($userModel->update($userId, $data)) {
        return $this->response->setJSON(['status' => 200, 'message' => 'Profile updated successfully.']);
    } else {
        return $this->response->setJSON(['status' => 500, 'message' => 'Failed to update profile.']);
    }
}

public function registerUser()
{
    helper(['form', 'text']);

    // Generate a secure default password
    $defaultPassword = $this->generateDefaultPassword();

    // Hash the password
    $hashedPassword = password_hash($defaultPassword, PASSWORD_BCRYPT);

    // Collect input data
    $data = [
        'name'                 => trim($this->request->getPost('name')),
        'email'                => trim($this->request->getPost('email')),
        'password'             => $hashedPassword,
        'role'                 => $this->request->getPost('role'),
        'county'               => $this->request->getPost('county'),
        'region'               => $this->request->getPost('region'),
        'status'               => $this->request->getPost('status'),
        'must_change_password' => 1 // Force password change on first login
    ];

    $userModel = new \App\Models\UserModel();

    // Check if email already exists
    if ($userModel->where('email', $data['email'])->first()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'A user with this email already exists.',
        ]);
    }

    // Insert the user into the database
    if (!$userModel->insert($data)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to register user.',
            'errors'  => $userModel->errors(),
        ]);
    }

    // Send account details via email
    $emailService = \Config\Services::email();
    $emailService->setTo($data['email']);
    $emailService->setSubject('Your Account Details');
    $emailService->setMessage(
        "Dear {$data['name']},\n\n" .
        "Your account has been created successfully.\n\n" .
        "🔑 Default Password: {$defaultPassword}\n\n" .
        "Please log in at: " . base_url('login') . "\n" .
        "⚠️ You will be required to change your password upon first login.\n\n" .
        "Regards,\nCase Management System Admin"
    );

    // Attempt to send the email
    if ($emailService->send()) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'User registered successfully. Email sent!',
        ]);
    } else {
        $debugOutput = $emailService->printDebugger(['headers']);
        log_message('error', 'Email failed to send: ' . print_r($debugOutput, true));

        return $this->response->setJSON([
            'success' => false,
            'message' => 'User registered, but email failed to send.',
            'debug'   => $debugOutput,
        ]);
    }
}


/**
 * Generate a secure default password.
 *
 * @return string
 */
private function generateDefaultPassword()
{
    $length = 8;
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $randomPassword = '';

    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomPassword;
}


public function resetPassword()
{
    $request = $this->request->getPost();

    // Validate input
    $validation = \Config\Services::validation();
    $validation->setRules([
        'email' => 'required|valid_email',
        'new_password' => 'required|min_length[8]',
    ]);

    if (!$validation->run($request)) {
        return $this->response->setJSON(['error' => $validation->getErrors()]);
    }

    $userModel = new UserModel();
    $user = $userModel->where('email', $request['email'])->first();

    if (!$user) {
        return $this->response->setJSON(['error' => 'User not found.']);
    }

    $newPasswordHash = password_hash($request['new_password'], PASSWORD_DEFAULT);
    $userModel->update($user['id'], ['password' => $newPasswordHash]);

    return $this->response->setJSON(['success' => 'Password reset successfully.']);
}
public function fetchLogs()
{
    $accessLogModel = new \App\Models\AccessLogModel();
    $logs = $accessLogModel->findAll();

    return $this->response->setJSON([
        'success' => true,
        'data' => $logs,
    ]);
}




}




