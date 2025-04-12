<?php

namespace App\Controllers;

class ErrorController
{
  public function forbidden(): void 
  {
    d("You are forbid to access this pace");
  }
}