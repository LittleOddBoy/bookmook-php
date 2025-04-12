<?php


namespace Framework\Middleware;

require_once('./helpers.php');

use Framework\Session;

class Authorize
{
  public function is_authenticated(): bool
  {
    return Session::get('authorized') ?? false;
  }

  public function handle(string $role): void
  {
    if ($role == "gust" and $this->is_authenticated()) {
      redirect('/');
      exit;
    } elseif ($role == "auth" and !$this->is_authenticated()) {
      redirect('/auth/login');
      exit;
    } else if ($role == "owner" and Session::get('user_data')['role'] != "owner") {
      redirect('/forbidden');
      exit;
    } else if ($role == "user" and Session::get('user_data')['role'] != "user") {
      redirect('/forbidden');
      exit;
    } else if ($role == "highs" and !in_array(Session::get('user_data')['role'], ['admin', 'owner'])) {
      redirect('/forbidden');
      exit;
    } else if ($role == "shopkeeper" and Session::get('user_data')['role'] != "shopkeeper") {
      redirect('/forbidden');
      exit;
    } else if ($role == "no_user" and Session::get('user_data')['role'] == "user") {
      redirect('/forbidden');
      exit;
    }
  }
}
