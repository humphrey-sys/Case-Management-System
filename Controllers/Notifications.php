<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class Notifications extends BaseController
{
    public function fetchOfficer()
    {
        $userId = session()->get('id');
        $role   = session()->get('role');

        if ($role !== 'officer') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);
        }

        $model = new NotificationModel();
        $data = $model->where('user_id', $userId)
                      ->orderBy('created_at', 'DESC')
                      ->findAll();

        return $this->response->setJSON($data);
    }

    public function markAsRead($id)
    {
        $notifModel = new NotificationModel();
        $notif = $notifModel->find($id);

        if ($notif && !$notif['is_read']) {
            $notifModel->update($id, ['is_read' => 1]);
            return $this->response->setJSON(['status' => 'read']);
        }

        return $this->response->setJSON(['status' => 'not_found'], 404);
    }

    public function getNotifications()
    {
        $notifModel = new NotificationModel();
        $userId = session()->get('user_id');

        $notifications = $notifModel
            ->where('user_id', $userId)
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON($notifications);
    }

    public function delete($id)
    {
        $notifModel = new NotificationModel();
        $notification = $notifModel->find($id);

        if ($notification) {
            $notifModel->delete($id);
            return $this->response->setJSON(['status' => 'deleted']);
        }

        return $this->response->setJSON(['status' => 'not_found'], 404);
    }

    public function superadminNotifications()
    {
        $userId = session()->get('id'); // superadmin ID
        $notificationModel = new NotificationModel();

        $notifications = $notificationModel
            ->where('user_id', $userId)
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON($notifications);
    }

    // ✅ NEW: Admin notification method
   public function adminNotifications()
{
    $userId = session()->get('id');
    $role = session()->get('role');
    $regionId = session()->get('region_id');

    // Check if the user is an admin and has valid session data
    if (!$userId || $role !== 'admin') {
        return $this->response
            ->setStatusCode(200) // still return 200 to avoid JS error
            ->setJSON([]); // return empty list
    }

    try {
        $model = new \App\Models\NotificationModel();

        $notifications = $model
            ->groupStart()
                ->where('user_id', $userId)
                ->orGroupStart()
                    ->where('region_id', $regionId)
                    ->where('user_id', null)
                ->groupEnd()
            ->groupEnd()
            ->where('role', 'admin')
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->response->setStatusCode(200)->setJSON($notifications);
    } catch (\Exception $e) {
        // In case of unexpected error, return empty array
        log_message('error', 'Admin notifications error: ' . $e->getMessage());
        return $this->response
            ->setStatusCode(200)
            ->setJSON([]); // no JS error — just no notifications
    }
}

}
