<?php

namespace App\Controllers;

class HomePanelController
{
  public function index() : void 
  {
    load_panel_view('home');
  }
}