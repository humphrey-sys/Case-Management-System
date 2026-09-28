<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';         // Database table name
    protected $primaryKey = 'id';      // Primary key
    protected $returnType = 'array';   // Return results as an array
    protected $useTimestamps = true;   // Automatically manage created_at and updated_at fields

    // Fields allowed for mass assignment
    protected $allowedFields = [
        'name', 
        'email', 
        'password', 
        'reset_token', 
        'reset_token_expiry',
        'role', 
        'county',
        'status', 
        'region', 
        'profilePicture', 
        'phone_number', 
        'date_of_birth', 
        'gender', 
        'address', 
        'emergency_contact',
        'otp_code',
        'otp_expires_at'
    ];

    // Validation rules for data integrity
    protected $validationRules = [
        'name' => 'required|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'permit_empty|min_length[8]',
        'role' => 'required|in_list[superadmin,admin,officer]',
        'status' => 'required|in_list[active,inactive]',
        'region' => 'required|max_length[100]',
        
    ];

    protected $validationMessages = [
        'email' => [
            'required' => 'The email field is required.',
            'valid_email' => 'Please provide a valid email address.',
            'is_unique' => 'This email is already registered.'
        ],
        'password' => [
            'min_length' => 'The password must be at least 8 characters long.',
        ],
        'role' => [
            'required' => 'The role field is required.',
            'in_list' => 'The role must be one of: superadmin, admin, officer.'
        ],
        'status' => [
            'required' => 'The status field is required.',
            'in_list' => 'The status must be either active or inactive.'
        ],
        'region' => [
            'required' => 'The region field is required.',
            'max_length' => 'The region cannot exceed 100 characters.'
        ],
        
            ];

    /**
     * Find a user by email.
     *
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Fetch users by region.
     *
     * @param string $region
     * @return array
     */
    public function findByRegion(string $region)
    {
        return $this->where('region', $region)->findAll();
    }
}
