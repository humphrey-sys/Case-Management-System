<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Setting extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    /**
     * Fetch all system settings (for AJAX)
     */
    public function fetchSettings()
    {
        try {
            $settings = $this->settingModel->getAllSettings();

            return $this->response->setJSON([
                'success' => true,
                'data'    => $settings
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error fetching settings',
                'error'   => $e->getMessage()
            ]);
        }
    }

    /**
     * Update system settings (AJAX form submission)
     */
    public function updateSettings()
    {
        try {
            $formData = $this->request->getPost();

            foreach ($formData as $key => $value) {
                $this->settingModel->updateSetting($key, $value);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update settings',
                'error'   => $e->getMessage()
            ]);
        }
    }

    /**
     * Reset all settings to their default values
     */
    public function resetDefaults()
    {
        $defaultSettings = [
            [
                'key_name'    => 'site_name',
                'value'       => 'Case Management System',
                'type'        => 'text',
                'description' => 'System name shown in the header',
                'options'     => null,
            ],
            [
                'key_name'    => 'maintenance_mode',
                'value'       => '0',
                'type'        => 'boolean',
                'description' => 'Enable or disable system maintenance mode',
                'options'     => null,
            ],
            [
                'key_name'    => 'email_notifications',
                'value'       => '1',
                'type'        => 'boolean',
                'description' => 'Send email alerts to users',
                'options'     => null,
            ],
            [
                'key_name'    => 'items_per_page',
                'value'       => '10',
                'type'        => 'number',
                'description' => 'Default pagination items per page',
                'options'     => null,
            ],
            [
                'key_name'    => 'theme_mode',
                'value'       => 'light',
                'type'        => 'select',
                'description' => 'Change application appearance (light/dark/auto)',
                'options'     => 'light,dark,auto',
            ],

        ];

        try {
            $this->settingModel->resetToDefaults($defaultSettings);

            return $this->response->setJSON([
                'success' => true,
                'message' => '✅ Settings have been reset to default values.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Reset failed: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => '❌ Failed to reset settings.',
                'error'   => $e->getMessage()
            ]);
        }
    }
}
