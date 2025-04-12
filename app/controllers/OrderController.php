<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;

class OrderController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(): void
  {
    $user_order_history_params = [Session::get('user_data')['user_id']];
    $user_order_history_query = "
      SELECT 
        o.id AS order_id,
        o.total_price,
        o.status,
        o.created_at,
        MIN(u.user_fullname) AS shopkeeper_name, -- Ensure a single value for shopkeeper name
        COUNT(oi.id) AS total_items
      FROM orders o
      JOIN order_items oi ON o.id = oi.order_id
      JOIN shopkeeper_books sb ON oi.shopkeeper_book_id = sb.id
      JOIN users u ON sb.shopkeeper_id = u.user_id
      WHERE o.user_id = ?
      GROUP BY o.id
      ORDER BY o.created_at DESC;
    ";
    $user_order_history = $this->db->fetch_all_as_object($user_order_history_query, $user_order_history_params);
    load_panel_view('orders/index', ['order_history' => $user_order_history]);
  }

  public function show(array $params): void
  {
    $order_id = $params['order_id'];

    $order_info_params = [$order_id];
    $order_info_query = "
        SELECT 
            o.id AS order_id,
            o.user_id,
            u.user_fullname AS customer_name,
            o.total_price,
            o.status,
            o.created_at AS order_date
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        WHERE o.id = ?
    ";
    $order_info = $this->db->query($order_info_query, $order_info_params)->fetch_object();

    $order_items_params = [$order_id];
    $order_items_query = "
        SELECT 
            oi.shopkeeper_book_id,
            sb.price AS price_per_unit,
            oi.quantity,
            oi.price_at_purchase,

            b.id AS book_id,
            b.title AS book_title,
            b.author AS book_author,
            b.isbn,

            sk.user_id AS shopkeeper_id,
            sk.user_fullname AS shopkeeper_name
        FROM order_items oi
        JOIN shopkeeper_books sb ON oi.shopkeeper_book_id = sb.id
        JOIN books b ON sb.book_id = b.id
        JOIN users sk ON sb.shopkeeper_id = sk.user_id
        WHERE oi.order_id = ?
    ";
    $order_items = $this->db->fetch_all_as_object($order_items_query, $order_items_params);

    $shopkeepers_in_order_params = [$order_id];
    $shopkeepers_in_order_query = "
        SELECT 
            o.id AS order_id,
            o.user_id,
            u.user_fullname AS customer_name,
            o.total_price,
            o.status,
            o.created_at AS order_date
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        WHERE o.id = ?
    ";
    $shopkeepers_in_order = $this->db->fetch_all_as_object($shopkeepers_in_order_query, $shopkeepers_in_order_params);

    load_panel_view('orders/show', ['order_info' => $order_info, 'order_items' => $order_items, 'shopkeepers' => $shopkeepers_in_order]);
  }
}
