<?php

namespace App\Models;

use CodeIgniter\Model;

class AccessLogModel extends Model
{
    protected $table = 'access_logs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', 'name', 'email', 'login_time',
        'logout_time', 'ip_address', 'device', 'location'
    ];

    public $useTimestamps = false;
}
