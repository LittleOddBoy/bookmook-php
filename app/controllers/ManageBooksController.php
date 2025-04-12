<?php

namespace App\Controllers;

use Framework\Session;
use Framework\Database;

class ManageBooksController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(): void
  {
    $all_books_query = "
        SELECT 
            sb.id AS shopkeeper_book_id,
            b.id AS book_id,
            b.title,
            b.author,
            b.isbn,
            b.published_at,
            sb.price,
            sb.stock,
            sb.status,
            sb.created_at AS listed_at,
            u.user_id AS shopkeeper_id,
            u.user_fullname AS shopkeeper_name,
            u.user_email AS shopkeeper_email
        FROM shopkeeper_books sb
        JOIN books b ON sb.book_id = b.id
        JOIN users u ON sb.shopkeeper_id = u.user_id
        ORDER BY sb.status ASC, b.title ASC;
    ";

    $all_books = $this->db->fetch_all_as_object($all_books_query);

    // Loop through each book to get its associated categories
    foreach ($all_books as $book) {
      // Fetch categories for each book
      $category_query = "
            SELECT c.name
            FROM categories c
            JOIN book_categories bc ON c.id = bc.category_id
            WHERE bc.book_id = ?
        ";

      $categories = $this->db->fetch_all_as_object($category_query, [$book->book_id]);

      // Join categories using the helper function
      $book->categories = join_categories(array_map(function ($category) {
        return $category->name;
      }, $categories));
    }

    // Load the panel view with the updated book data
    load_panel_view('books/index', ['books' => $all_books]);
  }

  public function approved(): void
  {
    $approved_books_query = "
        SELECT 
            sb.id AS shopkeeper_book_id,
            b.id AS book_id,
            b.title,
            b.author,
            b.isbn,
            b.published_at,
            sb.price,
            sb.stock,
            sb.status,
            sb.created_at AS listed_at,
            u.user_id AS shopkeeper_id,
            u.user_fullname AS shopkeeper_name,
            u.user_email AS shopkeeper_email
        FROM shopkeeper_books sb
        JOIN books b ON sb.book_id = b.id
        JOIN users u ON sb.shopkeeper_id = u.user_id
        WHERE sb.status = 'approved'
        ORDER BY b.title ASC;
    ";

    $approved_books = $this->db->fetch_all_as_object($approved_books_query);

    // Loop through each approved book to get its associated categories
    foreach ($approved_books as $book) {
      // Fetch categories for each book
      $category_query = "
            SELECT c.name
            FROM categories c
            JOIN book_categories bc ON c.id = bc.category_id
            WHERE bc.book_id = ?
        ";

      $categories = $this->db->fetch_all_as_object($category_query, [$book->book_id]);

      // Join categories using the helper function
      $book->categories = join_categories(array_map(function ($category) {
        return $category->name;
      }, $categories));
    }

    // Load the panel view with the updated book data
    load_panel_view('books/approved', ['books' => $approved_books]);
  }

  public function pending(): void
  {
    $pending_books_query = "
        SELECT 
            sb.id AS shopkeeper_book_id,
            b.id AS book_id,
            b.title,
            b.author,
            b.isbn,
            b.published_at,
            sb.price,
            sb.stock,
            sb.status,
            sb.created_at AS listed_at,
            u.user_id AS shopkeeper_id,
            u.user_fullname AS shopkeeper_name,
            u.user_email AS shopkeeper_email
        FROM shopkeeper_books sb
        JOIN books b ON sb.book_id = b.id
        JOIN users u ON sb.shopkeeper_id = u.user_id
        WHERE sb.status = 'pending'
        ORDER BY b.title ASC;
    ";

    $pending_books = $this->db->fetch_all_as_object($pending_books_query);

    // Loop through each pending book to get its associated categories
    foreach ($pending_books as $book) {
      // Fetch categories for each book
      $category_query = "
            SELECT c.name
            FROM categories c
            JOIN book_categories bc ON c.id = bc.category_id
            WHERE bc.book_id = ?
        ";

      $categories = $this->db->fetch_all_as_object($category_query, [$book->book_id]);

      // Join categories using the helper function
      $book->categories = join_categories(array_map(function ($category) {
        return $category->name;
      }, $categories));
    }

    // Load the panel view with the updated book data
    load_panel_view('books/pending', ['books' => $pending_books]);
  }

  public function rejected(): void
  {
    $rejected_books_query = "
        SELECT 
            sb.id AS shopkeeper_book_id,
            b.id AS book_id,
            b.title,
            b.author,
            b.isbn,
            b.published_at,
            sb.price,
            sb.stock,
            sb.status,
            sb.created_at AS listed_at,
            u.user_id AS shopkeeper_id,
            u.user_fullname AS shopkeeper_name,
            u.user_email AS shopkeeper_email
        FROM shopkeeper_books sb
        JOIN books b ON sb.book_id = b.id
        JOIN users u ON sb.shopkeeper_id = u.user_id
        WHERE sb.status = 'rejected'
        ORDER BY b.title ASC;
    ";

    $rejected_books = $this->db->fetch_all_as_object($rejected_books_query);

    // Loop through each rejected book to get its associated categories
    foreach ($rejected_books as $book) {
      // Fetch categories for each book
      $category_query = "
            SELECT c.name
            FROM categories c
            JOIN book_categories bc ON c.id = bc.category_id
            WHERE bc.book_id = ?
        ";

      $categories = $this->db->fetch_all_as_object($category_query, [$book->book_id]);

      // Join categories using the helper function
      $book->categories = join_categories(array_map(function ($category) {
        return $category->name;
      }, $categories));
    }

    // Load the panel view with the updated book data
    load_panel_view('books/rejected', ['books' => $rejected_books]);
  }

  public function stopped(): void
  {
    $stopped_books_query = "
        SELECT 
            sb.id AS shopkeeper_book_id,
            b.id AS book_id,
            b.title,
            b.author,
            b.isbn,
            b.published_at,
            sb.price,
            sb.stock,
            sb.status,
            sb.created_at AS listed_at,
            u.user_id AS shopkeeper_id,
            u.user_fullname AS shopkeeper_name,
            u.user_email AS shopkeeper_email
        FROM shopkeeper_books sb
        JOIN books b ON sb.book_id = b.id
        JOIN users u ON sb.shopkeeper_id = u.user_id
        WHERE sb.status = 'stopped'
        ORDER BY b.title ASC;
    ";

    $stopped_books = $this->db->fetch_all_as_object($stopped_books_query);

    // Loop through each stopped book to get its associated categories
    foreach ($stopped_books as $book) {
      // Fetch categories for each book
      $category_query = "
            SELECT c.name
            FROM categories c
            JOIN book_categories bc ON c.id = bc.category_id
            WHERE bc.book_id = ?
        ";

      $categories = $this->db->fetch_all_as_object($category_query, [$book->book_id]);

      // Join categories using the helper function
      $book->categories = join_categories(array_map(function ($category) {
        return $category->name;
      }, $categories));
    }

    // Load the panel view with the updated book data
    load_panel_view('books/stopped', ['books' => $stopped_books]);
  }

  public function show(array $params): void
  {
    $shopkeeper_id = $params['shopkeeper_id'];

    $shopkeeper_books_params = [$shopkeeper_id];
    $shopkeeper_books_query = "
        SELECT 
            sb.id AS shopkeeper_book_id,
            b.id AS book_id,
            b.title,
            b.author,
            b.isbn,
            b.published_at,
            sb.price,
            sb.stock,
            sb.status,
            sb.created_at
        FROM shopkeeper_books sb
        JOIN books b ON sb.book_id = b.id
        WHERE sb.shopkeeper_id = ?
        ORDER BY sb.status ASC, b.title ASC;
    ";

    $shopkeeper_books = $this->db->fetch_all_as_object($shopkeeper_books_query, $shopkeeper_books_params);

    // Loop through each shopkeeper's book to get its associated categories
    foreach ($shopkeeper_books as $book) {
      // Fetch categories for each book
      $category_query = "
            SELECT c.name
            FROM categories c
            JOIN book_categories bc ON c.id = bc.category_id
            WHERE bc.book_id = ?
        ";

      $categories = $this->db->fetch_all_as_object($category_query, [$book->book_id]);

      // Join categories using the helper function
      $book->categories = join_categories(array_map(function ($category) {
        return $category->name;
      }, $categories));
    }

    // Load the panel view with the updated book data
    load_panel_view('books/show', ['books' => $shopkeeper_books]);
  }


  public function create(): void
  {
    load_panel_view('books/create');
  }

  public function edit(array $params): void
  {
    $shopkeeper_id = $params['shopkeeper_id'];
    $shopkeeper_book_id = $params['shopkeeper_book_id'];

    // Step 1: Fetch the book info from this specific shopkeeper
    $book_information_params = [$shopkeeper_book_id, $shopkeeper_id];
    $book_information_query = "
            SELECT 
                sb.id AS shopkeeper_book_id, 
                sb.book_id, 
                sb.price, 
                sb.stock, 
                sb.status, 
                b.title, 
                b.author, 
                b.description, 
                b.genre, 
                b.isbn, 
                b.published_at 
            FROM shopkeeper_books sb
            JOIN books b ON sb.book_id = b.id
            WHERE sb.id = ? AND sb.shopkeeper_id = ?
        ";

    $book_information = $this->db->query($book_information_query, $book_information_params)->fetch_object();

    // Step 2: Fetch its categories and attach to the book object
    if ($book_information) {
      $book_id = $book_information->book_id;

      $categories_query = "
                SELECT c.name AS category_name
                FROM book_categories bc
                JOIN categories c ON bc.category_id = c.id
                WHERE bc.book_id = ?
            ";

      $categories = $this->db->fetch_all_as_object($categories_query, [$book_id]);

      $book_information->categories = array_map(fn($c) => $c->category_name, $categories);
    }

    $book_categories_in_text = "";
    foreach ($book_information->categories as $key => $c) {
      $book_categories_in_text .= (string) $c;

      if ($key != count($book_information->categories) - 1) $book_categories_in_text .= "، ";
    }
    $book_information->categories = $book_categories_in_text;
    // d($book_information);
    // die;

    load_panel_view('books/edit', ['book' => $book_information]);
  }

  public function store(): void
  {
    // Get the form data
    $book_title = $_POST['title'];
    $book_author = $_POST['author'];
    $book_description = $_POST['description'];
    $book_isbn = $_POST['isbn'];
    $book_published_at = $_POST['published_at'];
    $book_price = $_POST['price'];
    $book_stock = $_POST['stock'];
    $book_image = $_FILES['image'];
    $categories_input = $_POST['categories'];  // New input for categories

    // TODO: handle $errors

    // TODO: check if the shopkeeper has the same book already

    // Check if the book already exists based on ISBN
    $existing_books_params = [$book_isbn];
    $existing_books_query = "SELECT id FROM books WHERE isbn = ?";
    $existing_books = $this->db->query($existing_books_query, $existing_books_params);
    $book_exists = false;

    if ($existing_books->num_rows > 0) {
      $existing_book = $existing_books->fetch_assoc();
      $status_params = [$existing_book['id']];
      $status_query = "SELECT sb.status FROM shopkeeper_books sb JOIN books b ON sb.book_id = b.id WHERE sb.book_id = ?";
      $status = $this->db->query($status_query, $status_params)->fetch_object();

      if ($status->status == 'approved') {
        $book_exists = true;
      }

      $book_id = $existing_book['id'];
      $book_title = $existing_book['title'];
      $book_author = $existing_book['author'];
      $book_description = $existing_book['description']; // TODO: they must be able to have separate descriptions! change the db for this task
    } else {
      $t = time();
      $target_file = base_path("uploads/book-covers/" . basename($book_image['name']));
      $target_file = base_path("uploads/book-covers/" . pathinfo($target_file, PATHINFO_FILENAME) . '-' . $t . '.' . pathinfo($target_file, PATHINFO_EXTENSION));
      move_uploaded_file($book_image['tmp_name'], $target_file);
      // Insert the new book
      $insert_book_params = [$book_title, $book_author, $book_description, $book_isbn, $book_published_at, pathinfo($target_file, PATHINFO_BASENAME)];
      $insert_book_query = "INSERT INTO books (title, author, description, isbn, published_at, created_at, image) 
                                VALUES (?, ?, ?, ?, ?, NOW(), ?)";
      $insert_book = $this->db->query($insert_book_query, $insert_book_params);

      $book_id = $this->db->get_last_inserted_id();
    }

    // Insert or update categories
    $category_ids = [];
    $categories = array_map('trim', explode('،', $categories_input));  // Split the input into individual categories

    foreach ($categories as $category_name) {
      // Check if the category already exists
      $existing_category = $this->db->query("SELECT id FROM categories WHERE name = ?", [$category_name])->fetch_object();

      if ($existing_category) {
        $category_ids[] = $existing_category->id;
      } else {
        // If the category doesn't exist, insert it
        $new_category = $this->db->query("INSERT INTO categories (name) VALUES (?)", [$category_name]);
        $new_category_id = $this->db->get_last_inserted_id();
        $category_ids[] = $new_category_id;
      }
    }

    // Insert the book into shopkeeper_books (price, stock, etc.)
    $book_status = $book_exists ? 'approved' : 'pending';
    $insert_shopkeeper_book_params = [Session::get('user_data')['user_id'], $book_id, $book_price, $book_stock, $book_status];
    $insert_shopkeeper_book_query = "INSERT INTO shopkeeper_books (shopkeeper_id, book_id, price, stock, status, created_at) 
                                      VALUES (?, ?, ?, ?, ?, NOW())";
    $insert_shopkeeper_book = $this->db->query($insert_shopkeeper_book_query, $insert_shopkeeper_book_params);

    // Now link the book with the categories in book_categories table
    foreach ($category_ids as $category_id) {
      $this->db->query("INSERT INTO book_categories (book_id, category_id) VALUES (?, ?)", [$book_id, $category_id]);
    }

    if ($book_exists) {
      Session::set_flash_message('success', 'کتاب با این شابک قبلا وجود داشت! ما اطلاعات اصلی را به جای اطلاعات شما گذاشتیم. کتاب به فروش گذاشته شد!');
      redirect('/panel/manage/books/' . Session::get('user_data')['user_id']);
      exit;
    }

    Session::set_flash_message('success', 'درخواست کتاب جدید با موفقیت ارسال شد! به محض تایید شدن کتاب به فروش گذاشته می‌شود.');
    redirect('/panel/manage/books/' . Session::get('user_data')['user_id']);
  }


  public function approve(array $params): void
  {
    $shopkeeper_book_id = $params['shopkeeper_book_id'];

    $approve_book_params = [$shopkeeper_book_id];
    $approve_book_query = "UPDATE shopkeeper_books SET status = 'approved' WHERE id = ?";
    $approve_book = $this->db->query($approve_book_query, $approve_book_params);

    Session::set_flash_message('success', 'درخواست کتاب با موفقیت تایید شد! کتاب به فروش گذاشته شد.');
    redirect('/panel/manage/books');
  }

  public function reject(array $params): void
  {
    $shopkeeper_book_id = $params['shopkeeper_book_id'];

    $reject_book_params = [$shopkeeper_book_id];
    $reject_book_query = "UPDATE shopkeeper_books SET status = 'rejected' WHERE id = ?";
    $reject_book = $this->db->query($reject_book_query, $reject_book_params);

    Session::set_flash_message('success', 'درخواست کتاب با موفقیت رد شد! کتاب به فروش گذاشته نشد.');
    redirect('/panel/manage/books');
  }

  public function stop(array $params): void
  {
    // TODO: delete the book from every user's cart 
    $shopkeeper_book_id = $params['shopkeeper_book_id'];

    $stop_book_params = [$shopkeeper_book_id];
    $stop_book_query = "UPDATE shopkeeper_books SET status = 'stopped' WHERE id = ?";
    $stop_book = $this->db->query($stop_book_query, $stop_book_params);

    Session::set_flash_message('success', 'فروش کتاب با موفقیت متوقف شد!');

    if (Session::get('user_data')['role'] == 'shopkeeper') {
      redirect('/panel/manage/books/' . Session::get('user_data')['user_id']);
      exit;
    }
    redirect('/panel/manage/books');
  }

  public function resume(array $params): void
  {
    $shopkeeper_book_id = $params['shopkeeper_book_id'];

    $resume_book_params = [$shopkeeper_book_id];
    $resume_book_query = "UPDATE shopkeeper_books SET status = 'approved' WHERE id = ?";
    $resume_book = $this->db->query($resume_book_query, $resume_book_params);

    Session::set_flash_message('success', 'فروش کتاب مورد نظر با موفقیت از سر گرفته شد!');

    if (Session::get('user_data')['role'] == 'shopkeeper') {
      redirect('/panel/manage/books/' . Session::get('user_data')['user_id']);
      exit;
    }
    redirect('/panel/manage/books');
  }

  public function update(array $params): void
  {
    $book_id = $params['book_id'];
    $updated_title = $_POST['title'];
    $updated_author = $_POST['author'];
    $updated_description = $_POST['description'];
    $updated_isbn = $_POST['isbn'];
    $updated_published_at = $_POST['published_at'];
    $updated_price = $_POST['price'];
    $updated_stock = $_POST['stock'];
    $updated_categories = $_POST['categories']; // Comma-separated string of categories

    // Update basic book information
    $update_book_info_params = [
      $updated_title,
      $updated_author,
      $updated_description,
      $updated_isbn,
      $updated_published_at,
      $book_id
    ];
    $update_book_info_query = "
        UPDATE books 
        SET title = ?, author = ?, description = ?, isbn = ?, published_at = ? 
        WHERE id = ?
    ";
    $this->db->query($update_book_info_query, $update_book_info_params);

    // Update the shopkeeper's book (price, stock)
    $update_mini_params = [
      $updated_price,
      $updated_stock,
      $book_id,
      Session::get('user_data')['user_id']
    ];
    $update_mini_query = "
        UPDATE shopkeeper_books 
        SET price = ?, stock = ? 
        WHERE book_id = ? AND shopkeeper_id = ?
    ";
    $this->db->query($update_mini_query, $update_mini_params);

    // Handle categories: split the comma-separated string and check/add categories
    $categories = array_map('trim', explode('،', $updated_categories)); // Split and trim categories
    $category_ids = [];

    // Fetch existing categories from the database or insert new ones
    foreach ($categories as $category_name) {
      // Check if the category already exists
      $category_check_query = "SELECT id FROM categories WHERE name = ?";
      $category_id_result = $this->db->query($category_check_query, [$category_name]);

      if ($category_id_result->num_rows > 0) {
        // Category exists, fetch its ID
        $category_id = $category_id_result->fetch_assoc()['id'];
      } else {
        // Category doesn't exist, insert it
        $category_insert_query = "INSERT INTO categories (name) VALUES (?)";
        $this->db->query($category_insert_query, [$category_name]);
        $category_id = $this->db->get_last_inserted_id(); // Get the inserted category ID
      }

      $category_ids[] = $category_id;
    }

    // Remove any existing categories for this book before adding the new ones
    $delete_existing_categories_query = "DELETE FROM book_categories WHERE book_id = ?";
    $this->db->query($delete_existing_categories_query, [$book_id]);

    // Insert new categories into the book_categories table
    foreach ($category_ids as $category_id) {
      $insert_book_category_query = "INSERT INTO book_categories (book_id, category_id) VALUES (?, ?)";
      $this->db->query($insert_book_category_query, [$book_id, $category_id]);
    }

    Session::set_flash_message('success', 'کتاب با موفقیت به روزرسانی شد!');
    redirect('/panel/manage/books');
  }


  public function update_mini(array $params): void
  {
    $shopkeeper_book_id = $params['shopkeeper_book_id'];
    $updated_price = $_POST['price'];
    $updated_stock = $_POST['stock'];

    $update_mini_params = [$updated_price, $updated_stock, $shopkeeper_book_id, Session::get('user_data')['user_id']];
    $update_mini_query = "UPDATE shopkeeper_books 
              SET price = ?, stock = ?
              WHERE id = ? AND shopkeeper_id = ?";
    $update_mini = $this->db->query($update_mini_query, $update_mini_params);

    Session::set_flash_message('success', 'کتاب با موفقیت به روزرسانی شد!');
    redirect('/panel/manage/books/' . Session::get('user_data')['user_id']);
  }

  // public function remove(array $params): void 
  // {

  // }
}
