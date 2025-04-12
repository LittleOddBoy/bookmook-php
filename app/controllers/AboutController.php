<?php

namespace App\Controllers;

class AboutController
{
  public function us(): void
  {
    load_view('about-us');
  }

  public function project(): void 
  {
    load_view('about-project');
  }
}
