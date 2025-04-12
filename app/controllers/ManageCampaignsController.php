<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;

class ManageCampaignsController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(): void
  {
    // Fetch all campaigns with general details
    $campaigns_query = "SELECT 
            c.id AS campaign_id, 
            c.name, 
            c.description, 
            c.start_date, 
            c.end_date
        FROM campaigns c";
    $campaigns = $this->db->fetch_all_as_object($campaigns_query);

    // Get campaign IDs for fetching book and stock info
    $campaign_ids = array_column($campaigns, 'campaign_id');

    if (!empty($campaign_ids)) {
      $placeholders = implode(',', array_fill(0, count($campaign_ids), '?'));

      // Fetch the total number of books and total stock for each campaign
      $campaign_books_data = $this->db->fetch_all_as_object(
        "SELECT cb.campaign_id, 
                    COUNT(DISTINCT cb.book_id) AS total_books, 
                    SUM(sb.stock) AS total_stock
             FROM campaign_books cb
             JOIN shopkeeper_books sb ON cb.book_id = sb.book_id
             WHERE cb.campaign_id IN ($placeholders)
             GROUP BY cb.campaign_id",
        $campaign_ids
      );

      // Map book and stock data to campaigns
      $campaign_stats = [];
      foreach ($campaign_books_data as $data) {
        $campaign_stats[$data->campaign_id] = [
          'total_books' => $data->total_books,
          'total_stock' => $data->total_stock
        ];
      }

      // Attach stats to each campaign
      foreach ($campaigns as $campaign) {
        $campaign->total_books = $campaign_stats[$campaign->campaign_id]['total_books'] ?? 0;
        $campaign->total_stock = $campaign_stats[$campaign->campaign_id]['total_stock'] ?? 0;
      }
    }

    load_panel_view('campaigns/index', ['campaigns' => $campaigns]);
  }

  public function add(): void
  {
    load_panel_view("campaigns/create");
  }

  public function store(): void
  {
    $new_campaign_name = $_POST['name'];
    $new_campaign_description = $_POST['description'];
    $new_campaign_start_date = $_POST['start_date'];
    $new_campaign_end_date = $_POST['end_date'];

    $start_new_campaign_params = [$new_campaign_name, $new_campaign_description, $new_campaign_start_date, $new_campaign_end_date];
    $start_new_campaign_query = "INSERT INTO campaigns (name, description, start_date, end_date, created_at) VALUES (?, ?, ?, ?, NOW())";
    $start_new_campaign = $this->db->query($start_new_campaign_query, $start_new_campaign_params);

    Session::set_flash_message('success', 'کمپین جدید با موفقیت شروع شد! کتاب‌ها یادتون نره!');
    redirect('/panel/manage/campaigns');
  }

  public function show(array $params): void
  {
    $campaign_id = $params['campaign_id'];

    // Fetch only approved books
    $all_books_query = "
        SELECT 
            b.id AS book_id, 
            b.title, 
            b.author, 
            b.description, 
            b.image, 
            b.isbn, 
            b.published_at 
        FROM books b
        JOIN shopkeeper_books sb ON b.id = sb.book_id
        WHERE sb.status = 'approved'
        GROUP BY b.id";

    $all_books = $this->db->fetch_all_as_object($all_books_query);

    // Get book IDs to check which ones are in the campaign
    $book_ids = array_column($all_books, 'book_id');

    if (!empty($book_ids)) {
      $placeholders = implode(',', array_fill(0, count($book_ids), '?'));

      // Fetch books that are part of this campaign
      $campaign_books_query = "
            SELECT book_id 
            FROM campaign_books 
            WHERE campaign_id = ? 
            AND book_id IN ($placeholders)";

      $campaign_books_data = $this->db->fetch_all_as_object($campaign_books_query, array_merge([$campaign_id], $book_ids));

      // Create a set of book IDs that are in the campaign
      $campaign_book_ids = array_column($campaign_books_data, 'book_id');

      // Mark books as included or not
      foreach ($all_books as $book) {
        $book->included_in_campaign = in_array($book->book_id, $campaign_book_ids);
      }
    }

    // d($all_books);
    // die;

    // Load the panel view with the campaign books
    load_panel_view('campaigns/show', [
      'books' => $all_books,
      'campaign_id' => $campaign_id
    ]);
  }


  public function add_book(array $params): void
  {
    $campaign_id = $params['campaign_id'];
    $book_id = $params['book_id'];

    // Check if the book is already in the campaign to prevent duplicates
    $check_query = "
        SELECT 1 FROM campaign_books 
        WHERE campaign_id = ? AND book_id = ?";
    $exists = $this->db->query($check_query, [$campaign_id, $book_id])->fetch_object();

    if (empty($exists)) {
      // Insert the book into the campaign
      $new_campaign_query = "
            INSERT INTO campaign_books (campaign_id, book_id) 
            VALUES (?, ?)";
      $new_campaign = $this->db->query($new_campaign_query, [$campaign_id, $book_id]);

      Session::set_flash_message('success', 'کتاب با موفقیت به کمپین اضافه شد!');
    } else {
      Session::set_flash_message('warning', 'این کتاب از قبل در کمپین وجود دارد!');
    }

    redirect("/panel/manage/campaigns/$campaign_id/books");
  }

  public function remove_book(array $params): void
  {
    $campaign_id = $params['campaign_id'];
    $book_id = $params['book_id'];

    // Delete the book from the campaign_books table
    $delete_query = "DELETE FROM campaign_books WHERE campaign_id = ? AND book_id = ?";
    $delete_campaign = $this->db->query($delete_query, [$campaign_id, $book_id]);

    Session::set_flash_message('success', 'کتاب با موفقیت از کمپین حذف شد!');

    // Redirect back or send a response
    redirect("/panel/manage/campaigns/$campaign_id/books");
  }
}
