<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Framework\Validation;

class SettingController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(): void
  {
    $site_settings_query = "SELECT setting_key, setting_value FROM site_settings;";
    $site_settings = $this->db->fetch_all_as_object($site_settings_query);

    $settings = [];
    foreach ($site_settings as $setting) {
      $settings[$setting->setting_key] = $setting->setting_value;
    }
    $settings = (object) $settings;
    load_panel_view('settings/index', ['settings' => $settings]);
  }

  public function update(): void
  {
    $site_email = $_POST['site_email'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];

    $site_settings = [
      [
        'setting_key' => 'site_email',
        'setting_value' => $site_email,
      ],
      [
        'setting_key' => 'contact_number',
        'setting_value' => $contact_number,
      ],
      [
        'setting_key' => 'address',
        'setting_value' => $address,
      ],
    ];

    foreach ($site_settings as $setting) {
      $update_setting_params = [$setting['setting_value'], $setting['setting_key']];
      $update_setting_query = "UPDATE site_settings SET setting_value = ? WHERE setting_key = ?";
      $update_setting = $this->db->query($update_setting_query, $update_setting_params);
    }

    Session::set_flash_message('success', 'تنظیمات سایت با موفقیت ویرایش شد!');
    redirect('/panel/settings');
  }
}
