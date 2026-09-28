<?php
namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $allowedFields = ['user_id', 'title', 'message', 'link', 'is_read', 'created_at'];
    public $timestamps = false;
}
