<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;

class PanelController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function dashboard(): void
  {
    load_panel_view('dashboard');
  }
}
