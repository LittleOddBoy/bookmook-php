<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;

class ShopkeeperController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(): void
  {
    $shopkeeper_requests_query = "SELECT 
                sr.id AS request_id,
                sr.user_id,
                u.user_fullname AS user_fullname,
                u.user_email AS user_email,
                sr.shop_name,
                sr.address,
                sr.commercial_email,
                sr.status,
                sr.created_at,
                sr.updated_at
              FROM shopkeeper_requests sr
              JOIN users u ON sr.user_id = u.user_id
              ORDER BY sr.status, sr.created_at DESC";

    $shopkeeper_requests = $this->db->fetch_all_as_object($shopkeeper_requests_query);
    load_panel_view('shopkeeper/index', ['requests' => $shopkeeper_requests]);
  }

  public function show(): void
  {
    $user_requests_params = [Session::get('user_data')['user_id']];
    $user_requests_query = "SELECT id, shop_name, status, created_at FROM shopkeeper_requests WHERE user_id = ? ORDER BY created_at DESC";

    $user_requests = $this->db->fetch_all_as_object($user_requests_query, $user_requests_params);
    load_panel_view('shopkeeper/show', ['requests' => $user_requests]);
  }

  public function create(): void
  {
    load_panel_view('shopkeeper/create');
  }

  public function request(): void
  {
    $user_id = Session::get('user_data')['user_id'];
    $shop_name = $_POST['shop_name'];
    $shop_commercial_email = $_POST['commercial_email'];
    $shop_address = $_POST['address'];

    // TODO: do the $errors after you found a good way for it

    $make_shopkeeper_request_params = [$user_id, $shop_name, $shop_address, $shop_commercial_email];
    $make_shopkeeper_request_query = "INSERT INTO shopkeeper_requests (user_id, shop_name, address, commercial_email, status, created_at) 
              VALUES (?, ?, ?, ?, 'pending', NOW())";
    $make_shopkeeper_request = $this->db->query($make_shopkeeper_request_query, $make_shopkeeper_request_params);

    Session::set_flash_message('success', 'درخواست شما با موفقیت ثبت شد!');
    redirect("/panel/" . Session::get("user_data")['user_id'] . "/to-be-shopkeeper");
  }

  public function approve(array $params): void
  {
    $request_id = $params['request_id'];

    $approve_request_params = [$request_id];
    $approve_request_query = "UPDATE shopkeeper_requests 
        SET status = 'approved', updated_at = NOW() 
        WHERE id = ?;
    ";
    $approve_request = $this->db->query($approve_request_query, $approve_request_params);

    $change_user_role_params = [$request_id];
    $change_user_role_query = "UPDATE users 
        SET user_role = 'shopkeeper' 
        WHERE user_id = (SELECT user_id FROM shopkeeper_requests WHERE id = ?)
    ";
    $change_user_role = $this->db->query($change_user_role_query, $change_user_role_params);

    Session::set_flash_message('success', 'درخواست کاربر با موفقیت تایید شد!');
    redirect('/panel/requests/to-be-shopkeeper');
  }

  public function reject(array $params): void
  {
    $request_id = $params['request_id'];

    $reject_request_params = [$request_id];
    $reject_request_query = "UPDATE shopkeeper_requests 
                        SET status = 'rejected', updated_at = NOW() 
                        WHERE id = ?";
    $reject_request = $this->db->query($reject_request_query, $reject_request_params);

    Session::set_flash_message('success', 'درخواست کاربر با موفقیت رد شد!');
    redirect('/panel/requests/to-be-shopkeeper');
  }

  // TODO: ability to cancel the request
}
