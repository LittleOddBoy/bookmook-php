<?php

namespace App\Controllers;

use Framework\Database;

class BookController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(): void
  {
    $category_filter = $_GET['category_filter'] ?? "";
    $category_order = $_GET['category_order'] ?? "همه";

    $all_books_params = [];
    $all_books_query =
      "SELECT 
            b.id AS book_id, 
            b.title, 
            b.author, 
            b.description, 
            b.image,
            b.isbn, 
            b.published_at, 
            sb.id AS shopkeeper_book_id, 
            sb.shopkeeper_id, 
            sb.price, 
            sb.stock,
            sb.created_at
        FROM shopkeeper_books sb
        JOIN books b ON sb.book_id = b.id
        WHERE sb.status = 'approved' 
        AND sb.stock > 0";

    // Apply category filter if selected
    if (!empty($category_filter) and $category_filter !== "همه") {
      $all_books_query .= "
            AND b.id IN (
                SELECT bc.book_id 
                FROM book_categories bc
                JOIN categories c ON bc.category_id = c.id
                WHERE c.name = ?
            )";
      $all_books_params[] = $category_filter;
    }

    $order = strtoupper($category_order) === 'ASC' ? 'ASC' : 'DESC'; // Prevent injection
    $all_books_query .= " ORDER BY sb.created_at $order";

    $all_books = $this->db->fetch_all_as_object($all_books_query, $all_books_params);

    $book_ids = array_column($all_books, 'book_id');

    if (!empty($book_ids)) {
      // Fetch categories separately
      $placeholders = implode(',', array_fill(0, count($book_ids), '?'));
      $categories_data = $this->db->fetch_all_as_object(
        "SELECT bc.book_id, c.name AS category_name
            FROM book_categories bc
            JOIN categories c ON bc.category_id = c.id
            WHERE bc.book_id IN ($placeholders)",
        $book_ids
      );

      // Map categories to books
      $categories_map = [];
      foreach ($categories_data as $category) {
        $categories_map[$category->book_id][] = $category->category_name;
      }

      // Add categories to each book entry
      foreach ($all_books as $book) {
        $book->categories = $categories_map[$book->book_id] ?? [];
      }
    }

    $categories_query = "SELECT * FROM categories";
    $categories = $this->db->fetch_all_as_object($categories_query);

    load_view('books/index', ['all_books' => $all_books, 'categories' => $categories]);
  }

  public function show(array $params): void
  {
    $shopkeeper_book_id = $params['shopkeeper_book_id'];


    $all_books_params = [$shopkeeper_book_id];
    $all_books_query = "
    SELECT 
          b.id AS book_id, 
          b.title, 
          b.author, 
          b.description, 
          b.image,
          b.isbn, 
          b.published_at, 
          sb.id AS shopkeeper_book_id, 
          sb.shopkeeper_id, 
          sb.price, 
          sb.stock,
          sb.created_at,
          u.user_fullname AS shopkeeper_name,
          JSON_ARRAYAGG(c.name) AS categories
      FROM shopkeeper_books sb
      JOIN books b ON sb.book_id = b.id
      JOIN users u ON sb.shopkeeper_id = u.user_id
      LEFT JOIN book_categories bc ON b.id = bc.book_id
      LEFT JOIN categories c ON bc.category_id = c.id
      WHERE sb.status = 'approved' 
      AND sb.stock > 0
      AND sb.id = ?
      GROUP BY sb.id, b.id, u.user_fullname; 
    ";


    $all_books = $this->db->fetch_all_as_object($all_books_query, $all_books_params);

    $book_ids = array_column($all_books, 'book_id');

    if (!empty($book_ids)) {
      // Fetch categories separately
      $placeholders = implode(',', array_fill(0, count($book_ids), '?'));
      $categories_data = $this->db->fetch_all_as_object(
        "SELECT bc.book_id, c.name AS category_name
            FROM book_categories bc
            JOIN categories c ON bc.category_id = c.id
            WHERE bc.book_id IN ($placeholders)",
        $book_ids
      );

      // Map categories to books
      $categories_map = [];
      foreach ($categories_data as $category) {
        $categories_map[$category->book_id][] = $category->category_name;
      }

      // Add categories to each book entry
      foreach ($all_books as $book) {
        $book->categories = $categories_map[$book->book_id] ?? [];
      }
    }

    load_view('books/show', ['book' => $all_books[0]]);
  }
}
