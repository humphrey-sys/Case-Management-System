<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key_name', 'value', 'description', 'type', 'options'];
    protected $useTimestamps = true;

    public function getAllSettings()
    {
        return $this->orderBy('key_name')->findAll();
    }

    public function updateSetting($key, $value)
    {
        return $this->where('key_name', $key)->set(['value' => $value])->update();
    }

    public function resetToDefaults(array $defaultSettings)
    {
        foreach ($defaultSettings as $setting) {
            $existing = $this->where('key_name', $setting['key_name'])->first();

            if ($existing) {
                $this->where('key_name', $setting['key_name'])
                     ->set(['value' => $setting['value']])
                     ->update();
            } else {
                $this->insert([
                    'key_name'    => $setting['key_name'],
                    'value'       => $setting['value'],
                    'type'        => $setting['type'] ?? 'text',
                    'description' => $setting['description'] ?? '',
                    'options'     => $setting['options'] ?? null,
                ]);
            }
        }

        return true;
    }
}
