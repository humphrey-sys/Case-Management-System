<?php

namespace App\Controllers;

use App\Models\AccessLogModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class AccessLogs extends Controller
{
    use ResponseTrait;

    public function fetchLogs()
    {
        $model = new AccessLogModel();
        $logs = $model->orderBy('login_time', 'DESC')->findAll();

        return $this->respond([
            'success' => true,
            'data' => $logs
        ]);
    }

    public function exportLogs()
    {
        $model = new AccessLogModel();
        $logs = $model->findAll();

        $filename = 'access_logs_' . date('YmdHis') . '.csv';
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $output = fopen("php://output", "w");
        fputcsv($output, ['Name', 'Email', 'Login Time', 'Logout Time', 'IP Address', 'Device', 'Place']);

        foreach ($logs as $log) {
            fputcsv($output, [
                $log['name'],
                $log['email'],
                $log['login_time'],
                $log['logout_time'],
                $log['ip_address'],
                $log['device'],
                $log['location']
            ]);
        }

        fclose($output);
        exit;
    }
}
