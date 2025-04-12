<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;

class ContactController
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

    load_view('contact/index', ['contact_info' => $settings]);
  }

  public function message(): void
  {
    $contact_fullname = $_POST['fullname'];
    $contact_email = $_POST['email'];
    $contact_message = $_POST['message'];

    $new_contact_message_query = "INSERT INTO contact_messages (fullname, email, message) VALUES (?, ?, ?)";
    $new_contact_message_params = [$contact_fullname, $contact_email, $contact_message];
    $new_contact_message = $this->db->query($new_contact_message_query, $new_contact_message_params);

    Session::set_flash_message("success", "پیام شما با موفقیت ثبت شد! در اسرع وقت از طریق ایمیل پاسخ خواهیم داد!");
    redirect('/contact-us');
  }

  public function all(): void
  {
    $all_contact_messages_query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
    $all_contact_messages = $this->db->fetch_all_as_object($all_contact_messages_query);

    load_panel_view('contact/index', ['messages' => $all_contact_messages]);
  }

  public function show(array $params): void
  {
    $message_id = $params['message_id'];

    $message_info_query = "SELECT * FROM contact_messages WHERE id = ?";
    $message_info_params = [$message_id];
    $message_info = $this->db->query($message_info_query, $message_info_params)->fetch_object();

    // die;
    load_panel_view('contact/show', ['message' => $message_info]);
  }
}
