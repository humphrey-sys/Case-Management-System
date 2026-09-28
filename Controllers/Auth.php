<?php

namespace App\Controllers;
use App\Models\userModel;
use App\Models\NotificationModel;
use App\Models\AccessLogModel;
use App\Models\RegionModel;



class Auth extends BaseController{
   
  public function store_case()
{
    $caseModel         = new \App\Models\CaseModel();
    $notificationModel = new \App\Models\NotificationModel();
    $userModel         = new \App\Models\UserModel();

    // Handle file upload
    $uploadedFilePath = null;
    $file = $this->request->getFile('uploads');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $uploadedFilePath = $file->store('uploads/documents');
    }

    // Collect input data
    $title      = $this->request->getPost('title');
    $officerId  = $this->request->getPost('officer_id');
    $region     = $this->request->getPost('region');
    $adminName  = session()->get('name'); // name of current admin

    $data = [
        'id'           => $this->request->getPost('id'),
        'title'        => $title,
        'description'  => $this->request->getPost('description'),
        'complainant'  => $this->request->getPost('complainant'),
        'id_no'        => $this->request->getPost('id_no'),
        'county'       => $this->request->getPost('county'),
        'region'       => $region,
        'uploads'      => $uploadedFilePath,
        'officer_id'   => $officerId,
        'status'       => $this->request->getPost('status'),
    ];

    // ✅ Attempt to insert the case
    if ($caseModel->insert($data)) {
        $caseId = $caseModel->getInsertID();

        // ✅ 1. Officer in-app notification
        $notificationModel->insert([
            'user_id'    => $officerId,
            'title'      => 'Case ID ' . $caseId . ' Assigned',
            'message'    => 'You have been assigned Case #' . $caseId . ': ' . $title,
            'link'       => base_url('dashboards/officer'),
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // ✅ 2. Officer email
        $officer = $userModel->find($officerId);
        if ($officer && isset($officer['email'])) {
            $email = \Config\Services::email();
            $email->setTo($officer['email']);
            $email->setSubject('New Case Assignment');
            $email->setMessage(
                "Hello {$officer['name']},\n\n" .
                "You have been assigned to a new case:\n\n" .
                "Case ID: {$caseId}\n" .
                "Title: {$title}\n\n" .
                "Regards,\n" .
                "Case System"
            );

            if (! $email->send()) {
                log_message('error', 'Officer email failed: ' . print_r($email->printDebugger(), true));
            }
        }

        // ✅ 3. Notify Superadmins (in-app + email)
        $superadmins = $userModel->where('role', 'superadmin')->findAll();
        foreach ($superadmins as $super) {
            // In-app
            $notificationModel->insert([
                'user_id'    => $super['id'],
                'title'      => 'New Case in Region: ' . $region,
                'message'    => 'Admin ' . $adminName . ' added Case #' . $caseId . ': ' . $title,
                'link'       => base_url('/superadmin/cases/view/' . $caseId),
                'is_read'    => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Email
            if (!empty($super['email'])) {
                $email = \Config\Services::email();
                $email->setTo($super['email']);
                $email->setSubject('New Case Added by Admin');
                $email->setMessage(
                    "Hello {$super['name']},\n\n" .
                    "A new case has been added by Admin {$adminName} in region: {$region}.\n\n" .
                    "Case ID: {$caseId}\n" .
                    "Title: {$title}\n\n" .
                    "View the case: " . base_url('/superadmin/cases/view/' . $caseId) . "\n\n" .
                    "Regards,\n" .
                    "Case Management System"
                );

                if (! $email->send()) {
                    log_message('error', 'Superadmin email failed: ' . print_r($email->printDebugger(), true));
                }
            }
        }

        // ✅ 4. Success response
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Case added successfully. Officer and Superadmin have been notified.'
        ]);
    }

    // ❌ Failure response
    return $this->response->setJSON([
        'success' => false,
        'message' => 'Failed to add the case.',
        'errors'  => $caseModel->errors()
    ]);
}  
public function loginForm()
{
    return view('login'); // <-- adjust path to your login view
}

    public function login()
{
    $session = session();
    $userModel = new \App\Models\UserModel();

    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $user = $userModel->where('email', $email)->first();

    if ($user && password_verify($password, $user['password'])) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Update user with OTP
        $updateData = [
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt
        ];
        $userModel->update($user['id'], $updateData);

        // Send OTP email
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Your OTP Code');
        $emailService->setMessage("Hello {$user['name']}, your OTP is: $otp. It expires in 5 minutes.");

        if (!$emailService->send()) {
            log_message('error', $emailService->printDebugger(['headers']));
            return redirect()->back()->with('error', 'Failed to send OTP. Try again.');
        }

        // Save temp session
        $session->set('temp_user_id', $user['id']);
        $session->set('otp_needed', true); // Set session variable for OTP

        return redirect()->to('/login'); // Stay on the login page
    }

    return redirect()->back()->with('error', 'Invalid credentials.');
}

public function verifyOtp()
{
    $session = session();
    $otp = $this->request->getPost('otp');
    $userId = $session->get('temp_user_id');

    if (!$userId) {
        return redirect()->to('/login')->with('error', 'Session expired. Please login again.');
    }

    $userModel = new \App\Models\UserModel();
    $user = $userModel->find($userId);

    if ($user && $user['otp_code'] == $otp && $user['otp_expires_at'] > date('Y-m-d H:i:s')) {
        // Clear OTP after successful verification
        $userModel->update($user['id'], [
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        // ✅ Check if user must change default password
        if (!empty($user['must_change_password'])) {
            // Only set limited session for password change
            $session->set([
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'role' => $user['role'],
                'region' => $user['region'],
                'isChangingPassword' => true
            ]);

            return redirect()->to('/force-change-password')
                ->with('info', 'You must change your default password before accessing the system.');
        }

        // ✅ Password has already been changed, continue with full login
        $session->set([
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'role' => $user['role'],
            'region' => $user['region'],
            'isLoggedIn' => true
        ]);

        // Log access
        $accessLog = new \App\Models\AccessLogModel();
        $accessLog->insert([
            'user_id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'ip_address' => $this->request->getIPAddress(),
            'device' => $this->request->getUserAgent()->getAgentString(),
            'location' => 'Unknown'
        ]);

        // Redirect to appropriate dashboard
        switch ($user['role']) {
            case 'superadmin':
                return redirect()->to('/dashboards/superadmin');
            case 'admin':
                return redirect()->to('/dashboards/admin');
            case 'officer':
                return redirect()->to('/dashboards/officer');
            default:
                $session->destroy();
                return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }
    }

    return redirect()->back()->with('error', 'Invalid or expired OTP.');
}


public function changePassword()
{
    $session = session();

    // Ensure user is only changing password (must_change_password)
    if (!$session->get('isChangingPassword')) {
        return redirect()->to('/login')->with('error', 'Unauthorized access.');
    }

    $userId = $session->get('id');
    $newPassword = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_password');

    if (!$newPassword || !$confirmPassword) {
        return redirect()->back()->with('change_error', 'Both fields are required.');
    }

    if ($newPassword !== $confirmPassword) {
        return redirect()->back()->with('change_error', 'Passwords do not match.');
    }

    if (strlen($newPassword) < 6) {
        return redirect()->back()->with('change_error', 'Password must be at least 6 characters.');
    }

    // Update user password and clear must_change_password flag
    $userModel = new \App\Models\UserModel();
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $userModel->update($userId, [
        'password' => $hashedPassword,
        'must_change_password' => null // or false/0 depending on your DB
    ]);

    // Update session to allow full login
    $session->remove(['isChangingPassword', 'must_change_password']);
    $session->set('isLoggedIn', true);

    // Optional: Log the password change access
    $accessLog = new \App\Models\AccessLogModel();
    $accessLog->insert([
        'user_id'    => $userId,
        'name'       => $session->get('name'),
        'email'      => $session->get('email'),
        'ip_address' => $this->request->getIPAddress(),
        'device'     => $this->request->getUserAgent()->getAgentString(),
        'location'   => 'Unknown'
    ]);

    // Redirect based on role
    $role = $session->get('role');
    switch ($role) {
        case 'superadmin':
            return redirect()->to('/dashboards/superadmin')->with('success', 'Password updated successfully.');
        case 'admin':
            return redirect()->to('/dashboards/admin')->with('success', 'Password updated successfully.');
        case 'officer':
            return redirect()->to('/dashboards/officer')->with('success', 'Password updated successfully.');
        default:
            $session->destroy();
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
    }
}


public function superadmin()
{
    $userModel = new \App\Models\UserModel();
    $caseModel = new \App\Models\CaseModel();
    $regionModel = new \App\Models\RegionModel();
    $countyModel = new \App\Models\CountyModel();
    $db = \Config\Database::connect();

    // Fetch officers
    $officers = $userModel->where('role', 'officer')->findAll();

    // Fetch recent cases (limit 5)
    $recentCases = $caseModel->orderBy('created_at', 'DESC')
                             ->limit(5)
                             ->findAll();

    // Case counts
    $totalCases = $caseModel->countAll();
    $openCases = $caseModel->where('status', 'open')->countAllResults();
    $resolvedCases = $caseModel->where('status', 'resolved')->countAllResults();
    $closedCases = $caseModel->where('status', 'closed')->countAllResults();

    // Cases grouped by region
    $casesPerRegion = $db->table('cases')
                         ->select('region, COUNT(*) as total')
                         ->groupBy('region')
                         ->get()
                         ->getResultArray();

    // Fetch regions and counties
    $regions = $regionModel->findAll();
    $counties = $countyModel->findAll();

    // Pass all data to view
    $data = [
        'totalCases' => $totalCases,
        'openCases' => $openCases,
        'resolvedCases' => $resolvedCases,
        'closedCases' => $closedCases,
        'totalUsers' => $userModel->countAll(),
        'totalAdmins' => $userModel->where('role', 'admin')->countAllResults(),
        'totalOfficers' => $userModel->where('role', 'officer')->countAllResults(),
        'casesResolvedThisMonth' => $this->getCasesResolvedThisMonth(),
        'recentCases' => $recentCases,
        'officers' => $officers,
        'casesPerRegion' => $casesPerRegion,
        'regions' => $regions,
        'counties' => $counties, 
    ];

    return view('dashboards/superadmin', $data);
}


public function admin()
{
    $userModel = new \App\Models\UserModel();
    $caseModel = new \App\Models\CaseModel();
    $regionModel = new \App\Models\RegionModel();
    $countyModel = new \App\Models\CountyModel();

    // Get the logged-in user's ID and region
    $userId = session()->get('id');
    $adminRegion = session()->get('region');

    if (!$userId || !$adminRegion) {
        return redirect()->to('/login')->with('error', 'Session error. Please log in again.');
    }

    // Fetch data filtered by the admin's region
    $totalUsers = $userModel->where('region', $adminRegion)->countAllResults();
    $totalCases = $caseModel->where('region', $adminRegion)->countAllResults();
    $openCases = $caseModel->where('status', 'open')->where('region', $adminRegion)->countAllResults();
    $closedCases = $caseModel->where('status', 'closed')->where('region', $adminRegion)->countAllResults();
    $recentCases = $caseModel->where('region', $adminRegion)
                             ->orderBy('created_at', 'DESC')
                             ->limit(5)
                             ->findAll();
    $totalAdmins = $userModel->where('role', 'admin')->where('region', $adminRegion)->countAllResults();
    $totalOfficers = $userModel->where('role', 'officer')->where('region', $adminRegion)->countAllResults();
    $casesResolvedThisMonth = $this->getCasesResolvedThisMonth($adminRegion);

    // Fetch officers in the admin's region
    $officers = $userModel->where('role', 'officer')->where('region', $adminRegion)->findAll();

    // ✅ Fetch all regions and counties
    $regions = $regionModel->findAll();
    $counties = $countyModel->findAll();

    // Pass data to the view
    return view('dashboards/admin', [
        'total_users' => $totalUsers,
        'total_admins' => $totalAdmins,
        'total_officers' => $totalOfficers,
        'total_cases' => $totalCases,
        'open_cases' => $openCases,
        'closed_cases' => $closedCases,
        'recent_cases' => $recentCases,
        'cases_resolved_this_month' => $casesResolvedThisMonth,
        'officers' => $officers,
        'region' => $adminRegion,
        'regions' => $regions,
        'counties' => $counties,
    ]);
}



    public function officer() {
       $userModel = new \App\Models\UserModel();
    $caseModel = new \App\Models\CaseModel();

   

    // Get the logged-in user's ID and region
    $userId = session()->get('id');
    $adminRegion = session()->get('region');

    if (!$userId || !$adminRegion) {
        return redirect()->to('/login')->with('error', 'Session error. Please log in again.');
    }

    // Fetch data filtered by the admin's region
    $totalUsers = $userModel->where('region', $adminRegion)->countAllResults();
    $totalCases = $caseModel->where('region', $adminRegion)->countAllResults();
    $openCases = $caseModel->where('status', 'open')->where('region', $adminRegion)->countAllResults();
    $closedCases = $caseModel->where('status', 'closed')->where('region', $adminRegion)->countAllResults();
    $recentCases = $caseModel->where('region', $adminRegion)
                             ->orderBy('created_at', 'DESC')
                             ->limit(5)
                             ->findAll();
    $totalAdmins = $userModel->where('role', 'admin')->where('region', $adminRegion)->countAllResults();
    $totalOfficers = $userModel->where('role', 'officer')->where('region', $adminRegion)->countAllResults();
    $casesResolvedThisMonth = $this->getCasesResolvedThisMonth($adminRegion); // Added

    // Fetch officers in the admin's region
    $officers = $userModel->where('role', 'officer')->where('region', $adminRegion)->findAll();

    // Pass data to the view
    return view('dashboards/officer', [
        'total_users' => $totalUsers,
        'total_admins' => $totalAdmins,
        'total_officers' => $totalOfficers,
        'total_cases' => $totalCases,
        'open_cases' => $openCases,
        'closed_cases' => $closedCases,
        'recent_cases' => $recentCases,
        'cases_resolved_this_month' => $casesResolvedThisMonth, // Added
        'officers' => $officers,
        'region' => $adminRegion,
    ]);
    }
    public function Home()
    {
        return view('Home');
    }
    public function About() {
        return view('About');
    }
    

public function logout()
{
    $userId = session()->get('id');

    if ($userId) {
        $accessLogModel = new \App\Models\AccessLogModel();

        // Find the most recent log for this user
        $lastLog = $accessLogModel
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastLog) {
            // Update logout_time with exact current time
            $accessLogModel->update($lastLog['id'], [
                'logout_time' => date('Y-m-d H:i:s')
            ]);
        } else {
            log_message('error', "⚠ No access log found for user ID: $userId during logout.");
        }
    }

    session()->destroy();
    return redirect()->to('/login');
}

public function fetch_cases() {
    $cases = $this->CaseModel->get_all_cases();
    echo json_encode($cases);
}
private function getCasesResolvedThisMonth()
{
    $caseModel = new \App\Models\CaseModel();

    // Define the start and end dates for the current month
    $startOfMonth = date('Y-m-01');
    $endOfMonth = date('Y-m-t');

    // Query the cases resolved in the current month
    $resolvedCases = $caseModel->where('status', 'closed')
                               ->where('updated_at >=', $startOfMonth)
                               ->where('updated_at <=', $endOfMonth)
                               ->countAllResults();

    return $resolvedCases;
}

public function verifyOtpForm()
{
    return view('verify_otp');
}


}
