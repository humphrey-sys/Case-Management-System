<?php
namespace App\Controllers;
use App\Models\CaseModel;
use App\Models\UserModel;


class Casecontroller extends BaseController
 {
       protected $caseModel;
    protected $userModel;
    public function __construct() {
       
        $this->caseModel = new CaseModel();
        $this->userModel = new UserModel();

        // Restrict access to Superadmin
        if (session()->get('role') !== 'superadmin') {
    return redirect()->to('unauthorized');
}

    }

    public function add_case()
{
    // Fetch officers for the dropdown
    $data['officers'] = $this->userModel->get_users_by_role('officer');
    
    // Return the view
    return view('add_case', $data);
}


   public function store_case()
{
    // Load validation service
    $validation = \Config\Services::validation();

    // Set validation rules
    $validation->setRules([
        'title' => 'required',
        'description' => 'required',
        'officer_id' => 'required',
    ]);

    // Run validation
    if (!$validation->withRequest($this->request)->run()) {
        // Return to the form with validation errors
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Gather form data
    $case_data = [
        'title' => $this->request->getPost('title'),
        'description' => $this->request->getPost('description'),
        'officer_id' => $this->request->getPost('officer_id'),
    ];

    // Save case data
    $this->caseModel->create_case($case_data);

    // Set success message
    session()->setFlashdata('success', 'Case added successfully!');

    // Redirect to superadmin dashboard
    return redirect()->to('dashboards/superadmin');
}
public function manage_cases() {
    $data['cases'] = $this->CaseModel->get_all_cases();
    $this->load->view('manage_cases', $data);
}

}
