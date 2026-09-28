<?php

namespace App\Models;

use CodeIgniter\Model;

class CaseModel extends Model
{
    protected $table = 'cases'; // Name of your table
    protected $primaryKey = 'id'; // Primary key of your table
    protected $allowedFields = [
        'title',
        'description',
        'county',
        'region',
        'id_no',
        'complainant',
        'uploads',
        'officer_id',
        'status',
        'created_at',
        'updated_at',
    ];
    protected $validationRules = [
    'title'       => 'required|min_length[3]|max_length[255]',
    'description' => 'required|min_length[5]',
    'complainant' => 'required|min_length[3]|max_length[255]',
    'id_no'       => 'required|numeric|min_length[8]|max_length[50]',
    'county'      => 'required|min_length[3]|max_length[255]', 
    'region'      => 'required|min_length[3]|max_length[255]',   
    'officer_id'  => 'required|integer',
    'status'      => 'required|in_list[open,closed]',
];

     
    
    public function getCasesByOfficerId(int $officerId)
    {
        return $this->where('officer_id', $officerId)->findAll();
    }
}
