<?php

namespace App\Controllers;

use Framework\Database;


class HomeController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(): void
  {
    // Step 1: Fetch the 4 most recent approved books with their shopkeeper and price info
    $most_recent_books_query = "
    SELECT 
        b.id AS book_id, 
        b.title, 
        b.author, 
        b.description, 
        b.image, 
        b.isbn, 
        b.published_at, 
        sb.price, 
        sb.stock, 
        sb.created_at, 
        u.user_fullname AS shopkeeper_name
    FROM shopkeeper_books sb
    JOIN books b ON sb.book_id = b.id
    JOIN users u ON sb.shopkeeper_id = u.user_id
    WHERE sb.status = 'approved'
    ORDER BY sb.created_at DESC
    LIMIT 4
";

    $most_recent_books = $this->db->fetch_all_as_object($most_recent_books_query);

    // Step 2: Get all the book IDs from the fetched books
    $book_ids = array_column($most_recent_books, 'book_id');

    // Step 3: Fetch their categories in one efficient query
    if (!empty($book_ids)) {
      $placeholders = implode(',', array_fill(0, count($book_ids), '?'));

      $categories_query = "
        SELECT bc.book_id, c.name AS category_name
        FROM book_categories bc
        JOIN categories c ON bc.category_id = c.id
        WHERE bc.book_id IN ($placeholders)
    ";

      $categories_data = $this->db->fetch_all_as_object($categories_query, $book_ids);

      // Step 4: Map categories to each book
      $categories_map = [];
      foreach ($categories_data as $row) {
        $categories_map[$row->book_id][] = $row->category_name;
      }

      // Step 5: Add categories to the most recent books
      foreach ($most_recent_books as $book) {
        $book->categories = $categories_map[$book->book_id] ?? [];
      }
    }


    // Step 1: Execute the first query to get all campaigns and up to 4 books per campaign
    $campaigns_query = "
        WITH LimitedCampaignBooks AS (
            SELECT 
                cb.campaign_id, 
                b.id AS book_id, 
                b.title, 
                b.author, 
                b.description, 
                b.image, 
                b.isbn, 
                b.published_at, 
                b.created_at,
                sb.price,
                sb.stock,
                ROW_NUMBER() OVER (PARTITION BY cb.campaign_id ORDER BY b.published_at DESC) AS row_num
            FROM campaign_books cb
            JOIN books b ON cb.book_id = b.id
            JOIN shopkeeper_books sb ON sb.book_id = b.id
        )
        SELECT 
            c.id AS campaign_id, 
            c.name, 
            c.description, 
            c.created_at, 
            COUNT(DISTINCT cb.book_id) AS total_books, 
            JSON_ARRAYAGG(
                JSON_OBJECT(
                    'book_id', lcb.book_id, 
                    'title', lcb.title, 
                    'author', lcb.author, 
                    'description', lcb.description, 
                    'image', lcb.image, 
                    'isbn', lcb.isbn, 
                    'created_at', lcb.created_at,
                    'published_at', lcb.published_at,
                    'price', lcb.price,
                    'stock', lcb.stock
                )
            ) AS campaign_books
        FROM campaigns c
        LEFT JOIN campaign_books cb ON c.id = cb.campaign_id
        LEFT JOIN LimitedCampaignBooks lcb ON c.id = lcb.campaign_id AND lcb.row_num <= 4
        GROUP BY c.id, c.name, c.description, c.created_at;
    ";

    $campaigns_data = $this->db->fetch_all_as_object($campaigns_query);

    // Step 2: Execute the second query to get categories for each book in the campaigns
    // Collect all the book IDs from the campaigns data
    $book_ids = [];
    foreach ($campaigns_data as $campaign) {
      $books = json_decode($campaign->campaign_books, true);
      foreach ($books as $book) {
        $book_ids[] = $book['book_id'];
      }
    }

    // Remove duplicates
    $book_ids = array_unique($book_ids);

    // Execute the second query to get categories for the books
    if (!empty($book_ids)) {
      $placeholders = implode(',', array_fill(0, count($book_ids), '?'));
      $categories_query = "
            SELECT 
                bc.book_id, 
                JSON_ARRAYAGG(c.name) AS categories 
            FROM book_categories bc
            JOIN categories c ON bc.category_id = c.id
            WHERE bc.book_id IN ($placeholders)
            GROUP BY bc.book_id;
        ";

      $categories_data = $this->db->fetch_all_as_object($categories_query, $book_ids);

      // Create a mapping of book_id to categories
      $categories_map = [];
      foreach ($categories_data as $category) {
        $categories_map[$category->book_id] = json_decode($category->categories, true);
      }

      // Step 3: Merge categories into each book
      foreach ($campaigns_data as &$campaign) {
        $books = json_decode($campaign->campaign_books, true);
        foreach ($books as &$book) {
          $book['categories'] = $categories_map[$book['book_id']] ?? [];
        }
        $campaign->campaign_books = $books;
      }
    }

    load_view('home', ['most_recent_books' => $most_recent_books, 'campaigns' => $campaigns_data]);
  }

  public function health(): void
  {
    d('Everything looks great!');
  }
}
