<?php
namespace App\Models;

use CodeIgniter\Model;

class SystemSettingsModel extends Model
{
    protected $table = 'system_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key_name', 'value', 'category', 'description'];
    protected $useTimestamps = true;
    protected $updatedField = 'updated_at';
}
