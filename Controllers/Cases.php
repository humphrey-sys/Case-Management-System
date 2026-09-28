<?php
namespace App\Controllers;

use App\Models\CaseModel;
use CodeIgniter\RESTful\ResourceController;

class Cases extends ResourceController
{
    public function __construct()
    {
        $this->caseModel = new CaseModel(); // Initialize the model
    }
    public function fetch_cases()
    {
        $caseModel = new CaseModel(); // Ensure you have a CaseModel
        $cases = $caseModel->findAll(); // Fetch all cases from the database

        return $this->response->setJSON($cases); // Return the data as JSON
    }
    public function case_details($id)
{
    try {
        $caseModel = new \App\Models\CaseModel();
        $case = $caseModel->find($id);

        if (!$case) {
            // Debug: Log or display the ID that is being searched
            log_message('error', "Case with ID {$id} not found.");
            echo "Case with ID {$id} not found."; // Debugging output
            exit;
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Case retrieved successfully.',
            'data' => $case
        ], 200);
    } catch (\Exception $e) {
        return $this->failServerError('An error occurred while retrieving the case: ' . $e->getMessage());
    }
}public function update_case()
{
    $caseModel         = new CaseModel();
    $notificationModel = new \App\Models\NotificationModel();
    $userModel         = new \App\Models\UserModel();

    $data = $this->request->getPost();
    $id   = $data['id'] ?? null;

    if (!$id || !$caseModel->find($id)) {
        return $this->respond([
            'status'  => 404,
            'message' => 'Case not found.',
        ], 404);
    }

    try {
        $caseModel->update($id, $data);

        $role   = session()->get('role');
        $name   = session()->get('name');
        $region = $data['region'] ?? 'N/A';
        $title  = $data['title'] ?? 'Case';
        $status = $data['status'] ?? null;

        $link = base_url('/cases/view/' . $id);

        // ✅ Notify Superadmins
        $superadmins = $userModel->where('role', 'superadmin')->findAll();

        foreach ($superadmins as $super) {
            $msg = "Officer {$name} updated status of Case #{$id}: {$title}.";
            if ($role === 'admin') {
                $msg = "Admin {$name} updated Case #{$id}: {$title} in {$region}.";
            }

            $notificationModel->insert([
                'user_id'    => $super['id'],
                'title'      => "Case ID{$id} Updated",
                'message'    => $msg,
                'link'       => $link,
                'is_read'    => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if (!empty($super['email'])) {
                $email = \Config\Services::email();
                $email->setTo($super['email']);
                $email->setSubject("Case Update Notification");
                $email->setMessage(
                    "Hello {$super['name']},\n\n{$msg}\n\nView case: {$link}\n\nRegards,\nCase Management System"
                );
                $email->send();
            }
        }

        // ✅ Also Notify Admin of Same Region if Officer did the update
        if ($role === 'officer') {
            $regionAdmins = $userModel->where('role', 'admin')->where('region', $region)->findAll();

            foreach ($regionAdmins as $admin) {
                $message = "Officer {$name} updated status of Case #{$id}: {$title} in your region.";

                $notificationModel->insert([
                    'user_id'    => $admin['id'],
                    'title'      => "Case Updated in {$region}",
                    'message'    => $message,
                    'link'       => $link,
                    'is_read'    => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                if (!empty($admin['email'])) {
                    $email = \Config\Services::email();
                    $email->setTo($admin['email']);
                    $email->setSubject("Case Update in Your Region");
                    $email->setMessage(
                        "Hello {$admin['name']},\n\n{$message}\n\nView case: {$link}\n\nRegards,\nCase Management System"
                    );
                    $email->send();
                }
            }
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Case updated successfully.',
        ], 200);

    } catch (\Exception $e) {
        return $this->failServerError('Failed to update the case: ' . $e->getMessage());
    }
}

public function fetchCases($officerId)
{
    if (empty($officerId)) {
        return $this->response->setJSON([
            'status' => 400,
            'message' => 'Officer ID is missing.'
        ]);
    }

    $cases = $this->caseModel->where('officer_id', $officerId)->findAll();

    if (empty($cases)) {
        return $this->response->setJSON([
            'status' => 404,
            'message' => 'No cases assigned to you.',
            'data' => []
        ]);
    }

    return $this->response->setJSON([
        'status' => 200,
        'message' => 'Cases retrieved successfully.',
        'data' => $cases
    ]);
}
public function delete_case($id)
{
    $caseModel = new \App\Models\CaseModel();

    $case = $caseModel->find($id);
    if (!$case) {
        return $this->response->setJSON([
            'status' => 404,
            'message' => 'Case not found.',
        ]);
    }

    if ($caseModel->delete($id)) {
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Case deleted successfully.',
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 500,
            'message' => 'Failed to delete case.',
        ]);
    }
}

public function fetch_cases_by_region()
{
    $caseModel = new \App\Models\CaseModel();
    $userRegion = session()->get('region'); // Fetch user's region from session

    if (!$userRegion) {
        return $this->response->setJSON([
            'status' => 401,
            'message' => 'Region not found. Please log in again.',
            'data' => []
        ]);
    }

    $cases = $caseModel->where('region', $userRegion)->findAll();

    return $this->response->setJSON([
        'status' => 200,
        'message' => 'Cases retrieved successfully.',
        'data' => $cases
    ]);
}
public function fetch_cases_by_officer()
{
    try {
        $caseModel = new CaseModel();

        // Get the logged-in officer's ID from the session
        $officerId = session()->get('id');

        if (!$officerId) {
            return $this->respond([
                'status' => 403,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        // Fetch cases assigned to the logged-in officer
        $cases = $caseModel->where('officer_id', $officerId)->findAll();

        if (!$cases) {
            return $this->respond([
                'status' => 404,
                'message' => 'No cases found for this officer.',
            ], 404);
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Cases retrieved successfully.',
            'data' => $cases,
        ], 200);
    } catch (\Exception $e) {
        return $this->failServerError('An error occurred: ' . $e->getMessage());
    }
}
public function dashboardSearch()
{
    $query = $this->request->getGet('query');

    if (!$query) {
        return $this->response->setJSON([
            'status' => 400,
            'message' => 'No search query provided.'
        ]);
    }

    $userModel = new \App\Models\UserModel();
    $caseModel = new \App\Models\CaseModel();
    

    $results = [];

    // Search Users (name or email)
    $users = $userModel->like('name', $query)
                       ->orLike('email', $query)
                       ->findAll();
    foreach ($users as $user) {
        $results[] = [
            'type' => 'User',
            'name' => $user['name'],
            'details' => 'Email: ' . $user['email'],
            'id' => $user['id']
        ];
    }

    // Search Cases (title or description)
    $cases = $caseModel->like('title', $query)
                       ->orLike('description', $query)
                       ->findAll();
    foreach ($cases as $case) {
        $results[] = [
            'type' => 'Case',
            'title' => $case['title'],
            'description' => $case['description'],
            'id' => $case['id']
        ];
    }

   


    return $this->response->setJSON([
        'status' => 200,
        'results' => $results
    ]);
}


}









