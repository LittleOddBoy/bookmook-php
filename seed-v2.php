<?php
$dsn = 'mysql:host=127.0.0.1;dbname=bookmook;charset=utf8mb4';
$username = 'ahk';
$password = '@HK-developer2008';

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo "Connected successfully.\n\n";

    // Clear all tables before seeding
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;
        TRUNCATE TABLE admin_logs;
        TRUNCATE TABLE order_items;
        TRUNCATE TABLE orders;
        TRUNCATE TABLE cart_items;
        TRUNCATE TABLE carts;
        TRUNCATE TABLE campaign_books;
        TRUNCATE TABLE campaigns;
        TRUNCATE TABLE shopkeeper_books;
        TRUNCATE TABLE book_categories;
        TRUNCATE TABLE categories;
        TRUNCATE TABLE books;
        TRUNCATE TABLE shopkeeper_requests;
        TRUNCATE TABLE users;
        TRUNCATE TABLE site_settings;
        SET FOREIGN_KEY_CHECKS = 1;
    ");

    // USERS
    $users = [
        ['Alice Johnson', 'alice@example.com', password_hash('password123', PASSWORD_BCRYPT), 'user'],
        ['Bob Smith', 'bob@example.com', password_hash('password123', PASSWORD_BCRYPT), 'shopkeeper'],
        ['Charlie Admin', 'charlie@example.com', password_hash('adminpass', PASSWORD_BCRYPT), 'admin'],
        ['Owner Man', 'owner@example.com', password_hash('ownerpass', PASSWORD_BCRYPT), 'owner'],
    ];

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    foreach ($users as $user) {
        $stmt->execute($user);
    }

    // SHOPKEEPER REQUESTS
    $shopkeeperRequests = [
        [2, 'Bob\'s Bookstore', '123 Book St, Library City', 'bob@store.com', 'approved'],
    ];

    $stmt = $pdo->prepare("INSERT INTO shopkeeper_requests (user_id, shop_name, address, commercial_email, status) VALUES (?, ?, ?, ?, ?)");
    foreach ($shopkeeperRequests as $req) {
        $stmt->execute($req);
    }

    // BOOKS
    $books = [
        ['The Great Gatsby', 'F. Scott Fitzgerald', 'A novel about the American dream.', 'Fiction', '9780743273565', '1925-04-10'],
        ['1984', 'George Orwell', 'A dystopian novel about totalitarianism.', 'Dystopian', '9780451524935', '1949-06-08'],
        ['Sapiens', 'Yuval Noah Harari', 'A brief history of humankind.', 'History', '9780062316097', '2011-01-01'],
    ];

    $stmt = $pdo->prepare("INSERT INTO books (title, author, description, genre, isbn, published_at) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($books as $book) {
        $stmt->execute($book);
    }

    // CATEGORIES
    $categories = ['Fiction', 'History', 'Science', 'Philosophy'];

    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    foreach ($categories as $cat) {
        $stmt->execute([$cat]);
    }

    // BOOK-CATEGORIES
    $bookCategories = [
        [1, 1],
        [2, 1],
        [3, 2],
    ];

    $stmt = $pdo->prepare("INSERT INTO book_categories (book_id, category_id) VALUES (?, ?)");
    foreach ($bookCategories as $bc) {
        $stmt->execute($bc);
    }

    // SHOPKEEPER_BOOKS
    $shopkeeperBooks = [
        [2, 1, 150.00, 10, 'approved'],
        [2, 2, 120.00, 8, 'approved'],
        [2, 3, 200.00, 5, 'approved'],
    ];

    $stmt = $pdo->prepare("INSERT INTO shopkeeper_books (shopkeeper_id, book_id, price, stock, status) VALUES (?, ?, ?, ?, ?)");
    foreach ($shopkeeperBooks as $sb) {
        $stmt->execute($sb);
    }

    // CAMPAIGNS
    $campaigns = [
        ['Spring Sale', '20% off selected books', '2025-04-01', '2025-04-30'],
        ['History Month', 'Promoting historical books', '2025-05-01', '2025-05-31'],
    ];

    $stmt = $pdo->prepare("INSERT INTO campaigns (name, description, start_date, end_date) VALUES (?, ?, ?, ?)");
    foreach ($campaigns as $camp) {
        $stmt->execute($camp);
    }

    // CAMPAIGN_BOOKS
    $campaignBooks = [
        [1, 1],
        [1, 2],
        [2, 3],
    ];

    $stmt = $pdo->prepare("INSERT INTO campaign_books (campaign_id, book_id) VALUES (?, ?)");
    foreach ($campaignBooks as $cb) {
        $stmt->execute($cb);
    }

    // CARTS
    $pdo->exec("INSERT INTO carts (user_id) VALUES (1)");
    $cartId = $pdo->lastInsertId();

    // CART_ITEMS
    $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, shopkeeper_book_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$cartId, 1, 2]);

    // ORDERS
    $pdo->exec("INSERT INTO orders (user_id, total_price, status) VALUES (1, 300.00, 'pending')");
    $orderId = $pdo->lastInsertId();

    // ORDER_ITEMS
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, shopkeeper_book_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");
    $stmt->execute([$orderId, 1, 2, 150.00]);

    // ADMIN LOGS
    $stmt = $pdo->prepare("INSERT INTO admin_logs (admin_id, action) VALUES (?, ?)");
    $stmt->execute([3, 'Approved shopkeeper request from Bob']);

    // SITE SETTINGS
    $settings = [
        ['site_name', 'BookMook Marketplace'],
        ['default_currency', 'IRR'],
        ['maintenance_mode', 'off'],
    ];

    $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
    foreach ($settings as $s) {
        $stmt->execute($s);
    }

    echo "Seeding completed successfully.\n";

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
?>
