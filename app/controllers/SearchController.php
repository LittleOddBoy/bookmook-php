<?php

namespace App\Controllers;

use Framework\Database;

class SearchController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(): void
  {
    $categories_query = "SELECT * FROM categories";
    $categories = $this->db->fetch_all_as_object($categories_query);

    load_view('search', ['categories' => $categories]);
  }

  public function search(): void
  {
    $category_filter = $_GET['category_filter'] ?? "";
    $category_order = $_GET['category_order'] ?? "همه";

    $search_keyword = $_GET['search_keyword'];
    $search_category = $_GET['search_category'] ?? 'همه';

    $search_sql_query = "%{$search_keyword}%";
    $search_params = [$search_sql_query, $search_sql_query, $search_sql_query];

    // Base query
    $search_query = "SELECT 
                b.id AS book_id, 
                b.title, 
                b.author, 
                b.description, 
                b.isbn, 
                b.image,
                b.created_at,
                b.published_at, 
                sb.price, 
                sb.stock, 
                sb.status, 
                u.user_fullname AS shopkeeper_name 
              FROM books b
              JOIN shopkeeper_books sb ON b.id = sb.book_id
              JOIN users u ON sb.shopkeeper_id = u.user_id
              WHERE (b.title LIKE ? OR b.author LIKE ? OR b.description LIKE ?)
              AND sb.status = 'approved'";

    // If a specific category is chosen, modify the query to filter by category
    if ($search_category !== 'همه') {
      $search_query .= " AND b.id IN (
            SELECT bc.book_id FROM book_categories bc
            JOIN categories c ON bc.category_id = c.id
            WHERE c.name = ?
        )";
      $search_params[] = $search_category;
    }

    $search_result = $this->db->fetch_all_as_object($search_query, $search_params);

    // Get book IDs to fetch their categories
    $book_ids = array_column($search_result, 'book_id');

    if (!empty($book_ids)) {
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
      foreach ($search_result as $book) {
        $book->categories = $categories_map[$book->book_id] ?? [];
      }
    }

    // Categories
    $categories_query = "SELECT * FROM categories";
    $categories = $this->db->fetch_all_as_object($categories_query);


    load_view('search', ['results' => $search_result, 'categories' => $categories]);
  }
}
