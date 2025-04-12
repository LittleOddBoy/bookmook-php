<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;

class CartController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(array $params): void
  {
    $user_id = $params['user_id'];
    $cart_items = $this->db->fetch_all_as_object(
      "
      SELECT 
        ci.id as cart_item_id,
        b.id AS book_id, 
        b.title, 
        b.author, 
        b.image,
        sb.stock,
        ci.quantity, 
        sb.price, 
        s.user_id AS shopkeeper_id, 
        s.user_fullname AS shopkeeper_name
      FROM carts c
      JOIN cart_items ci ON c.cart_id = ci.cart_id
      JOIN shopkeeper_books sb ON ci.shopkeeper_book_id = sb.id
      JOIN books b ON sb.book_id = b.id
      JOIN users s ON sb.shopkeeper_id = s.user_id
      WHERE c.cart_user_id = ?
      ",
      [$user_id]
    );

    if (!$cart_items) {
      load_view('cart/empty-cart');
      exit;
    }

    load_view('cart/cart', ['cart_items' => $cart_items]);
  }

  public function change_quantity(array $params): void
  {
    $update_params = [$_POST['quantity'], $params['user_cart_id'], $params['cart_item_id']];
    $update_quantity = $this->db->query("UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND id = ?", $update_params);

    redirect("/cart" . "/" . Session::get('user_data')['user_id']);
  }

  public function remove_item(array $params): void
  {
    $remove_params = [$params['user_cart_id'], $params['cart_item_id']];
    $remove_cart_item = $this->db->query("DELETE FROM cart_items WHERE cart_id = ? AND id = ?", $remove_params);
    redirect("/cart" . "/" . Session::get('user_data')['user_id']);
  }

  public function store(array $params): void
  {
    $user_cart_items_params = [$params['user_cart_id'], $params['shopkeeper_book_id']];
    $user_cart_items = $this->db->query('SELECT * FROM cart_items WHERE cart_id = ? AND shopkeeper_book_id = ?', $user_cart_items_params)->fetch_object();

    $book_stock_params = [$params['shopkeeper_book_id']];
    $book_stock = $this->db->query('SELECT * FROM shopkeeper_books WHERE book_id = ?', $book_stock_params)->fetch_object();


    if ($user_cart_items) {
      if ($user_cart_items->quantity < $book_stock->stock) {
        $update_cart_item = $this->db->query('UPDATE cart_items SET quantity = quantity + 1 WHERE cart_id = ? AND shopkeeper_book_id = ?', $user_cart_items_params);
      } else {
        Session::set_flash_message('error', 'موجودی محصول تمام شده است!');
        redirect('/books');
      }
    } else {
      $create_new_cart_item_params = [$params['user_cart_id'], $params['shopkeeper_book_id'], 1];
      $create_new_cart_item = $this->db->query("
        INSERT INTO cart_items (cart_id, shopkeeper_book_id, quantity)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity);
      ", $create_new_cart_item_params);
    }

    Session::set_flash_message('success', 'محصول مورد نظر به سبد خرید اضافه شد!');

    redirect('/books');
  }

  public function make_empty(array $params): void
  {
    $empty_cart_params = [$params['user_cart_id']];
    $empty_cart = $this->db->query('DELETE FROM cart_items WHERE cart_id = ?', $empty_cart_params);


    redirect('/cart' . '/' . Session::get('user_data')['user_id']);
  }

  public function calculate(array $params): void
  {
    $query = "SELECT 
                ci.id AS cart_item_id,
                ci.quantity, 
                sb.price, 
                (ci.quantity * sb.price) AS total_price_per_item, 
                b.title, 
                b.author
              FROM cart_items ci
              JOIN shopkeeper_books sb ON ci.shopkeeper_book_id = sb.id
              JOIN books b ON sb.book_id = b.id
              WHERE ci.cart_id = ?";

    $result = $this->db->fetch_all_as_object($query, [$params['user_cart_id']]);

    $total = 0;
    foreach ($result as $item) {
      $total += $item->total_price_per_item;
    }

    Session::set('total_order_price', $total);
    load_view('cart/calculate', ['overall' => $result, 'total' => $total]);
  }

  public function finalize(array $params): void
  {
    $create_order_params = [$params['user_id'], Session::get('total_order_price')];
    $create_order = $this->db->query("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')", $create_order_params);

    $append_order_items_params = [$this->db->get_last_inserted_id(), Session::get('user_data')['user_id']];
    $append_order_items_query = "
        INSERT INTO order_items (order_id, shopkeeper_book_id, quantity, price_at_purchase)
        SELECT ?, ci.shopkeeper_book_id, ci.quantity, sb.price
        FROM cart_items ci
        JOIN shopkeeper_books sb ON ci.shopkeeper_book_id = sb.id
        JOIN carts c ON ci.cart_id = c.cart_id
        WHERE c.cart_user_id = ?
    ";
    $append_order_items = $this->db->query($append_order_items_query, $append_order_items_params);

    $cart_items_query = "SELECT ci.shopkeeper_book_id, ci.quantity, sb.price 
                       FROM cart_items ci 
                       JOIN shopkeeper_books sb ON ci.shopkeeper_book_id = sb.id
                       WHERE ci.cart_id = (SELECT cart_id FROM carts WHERE cart_user_id = ?)";
    $cart_items = $this->db->fetch_all_as_object($cart_items_query, [$params['user_id']]);

    foreach ($cart_items as $item) {
      $decrease_quantity_query = "UPDATE shopkeeper_books SET stock = stock - ? WHERE id = ?";
      $this->db->query($decrease_quantity_query, [$item->quantity, $item->shopkeeper_book_id]);
    }

    $clear_cart_query = "DELETE FROM cart_items WHERE cart_id = (SELECT cart_id FROM carts WHERE cart_user_id = ?)";
    $this->db->query($clear_cart_query, [$params['user_id']]);

    load_view('cart/finalize');
  }
}
