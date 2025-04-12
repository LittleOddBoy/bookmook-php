<?php
// Database connection settings
$host = "localhost";
$dbname = "bookmook_copy"; // Change if needed
$username = "ahk"; // Change if needed
$password = "@HK-developer2008"; // Change if needed

// Connect to MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Function to hash passwords
function hashPassword($password)
{
  return password_hash($password, PASSWORD_BCRYPT);
}

// --- SEEDING USERS ---
$users = [
  ["علی رضایی", "ali@bookmook.ir", hashPassword("password123"), "user"],
  ["سارا محمودی", "sara@bookmook.ir", hashPassword("password123"), "shopkeeper"],
  ["رضا عباسی", "admin@bookmook.ir", hashPassword("adminpass"), "admin"],
  ["دکتر محمدی", "owner@bookmook.ir", hashPassword("ownerpass"), "owner"]
];

foreach ($users as $user) {
  $sql = "INSERT INTO users (name, email, password, role) VALUES ('$user[0]', '$user[1]', '$user[2]', '$user[3]')";
  $conn->query($sql);
}

// --- SEEDING SHOPKEEPER REQUESTS (Pending Shopkeepers) ---
$shopkeeper_requests = [
  [1, "کتاب فروشی علی", "تهران، خیابان ولیعصر", "ali.shop@example.com", "pending"],
  [3, "فروشگاه کتاب صبا", "مشهد، خیابان احمدآباد", "saba.books@example.com", "approved"]
];

foreach ($shopkeeper_requests as $req) {
  $sql = "INSERT INTO shopkeeper_requests (user_id, shop_name, address, commercial_email, status) 
            VALUES ($req[0], '$req[1]', '$req[2]', '$req[3]', '$req[4]')";
  $conn->query($sql);
}

// --- SEEDING BOOKS ---
$books = [
  ["کلیدر", "محمود دولت‌آبادی", "یک رمان حماسی از ایران", "ادبیات فارسی", "978-9643514333", "1984-01-01"],
  ["بوف کور", "صادق هدایت", "داستانی نمادین از ادبیات مدرن ایران", "ادبیات فارسی", "978-9644483256", "1937-01-01"],
  ["شازده احتجاب", "هوشنگ گلشیری", "رمانی دربارهٔ زوال یک خاندان قاجاری", "ادبیات فارسی", "978-9643113112", "1968-01-01"],
  ["The Brothers Karamazov", "Fyodor Dostoevsky", "A philosophical novel", "Classic", "978-0140449242", "1880-11-01"],
  ["1984", "George Orwell", "Dystopian fiction", "Science Fiction", "978-0451524935", "1949-06-08"]
];

foreach ($books as $book) {
  $sql = "INSERT INTO books (title, author, description, genre, isbn, published_at) 
            VALUES ('$book[0]', '$book[1]', '$book[2]', '$book[3]', '$book[4]', '$book[5]')";
  $conn->query($sql);
}

// --- SEEDING SHOPKEEPER BOOKS ---
$shopkeeper_books = [
  [2, 1, 150000, 5, "approved"],  // Sara sells "کلیدر"
  [2, 2, 80000, 10, "approved"],  // Sara sells "بوف کور"
  [2, 3, 90000, 7, "approved"],   // Sara sells "شازده احتجاب"
  [2, 4, 120000, 4, "pending"],   // "The Brothers Karamazov" awaiting approval
];

foreach ($shopkeeper_books as $shop) {
  $sql = "INSERT INTO shopkeeper_books (shopkeeper_id, book_id, price, stock, status) 
            VALUES ($shop[0], $shop[1], $shop[2], $shop[3], '$shop[4]')";
  $conn->query($sql);
}

// --- SEEDING CAMPAIGNS ---
$campaigns = [
  ["تخفیف نوروزی", "کتاب‌های منتخب با ۲۰٪ تخفیف", "2025-03-20", "2025-04-05"],
  ["کتاب‌های کلاسیک", "بهترین رمان‌های کلاسیک", "2025-06-01", "2025-06-30"]
];

foreach ($campaigns as $campaign) {
  $sql = "INSERT INTO campaigns (name, description, start_date, end_date) 
            VALUES ('$campaign[0]', '$campaign[1]', '$campaign[2]', '$campaign[3]')";
  $conn->query($sql);
}

// --- SEEDING CAMPAIGN BOOKS ---
$campaign_books = [
  [1, 1], // "کلیدر" in نوروزی campaign
  [1, 2], // "بوف کور" in نوروزی campaign
  [2, 4]  // "The Brothers Karamazov" in کلاسیک campaign
];

foreach ($campaign_books as $cb) {
  $sql = "INSERT INTO campaign_books (campaign_id, book_id) 
            VALUES ($cb[0], $cb[1])";
  $conn->query($sql);
}

// --- SEEDING CARTS ---
$cart_id = 1; // Simulated cart for user 1
$conn->query("INSERT INTO carts (user_id) VALUES (1)");

// --- SEEDING CART ITEMS ---
$cart_items = [
  [$cart_id, 1, 2],  // 2 copies of "کلیدر"
  [$cart_id, 2, 1]   // 1 copy of "بوف کور"
];

foreach ($cart_items as $item) {
  $sql = "INSERT INTO cart_items (cart_id, shopkeeper_book_id, quantity) 
            VALUES ($item[0], $item[1], $item[2])";
  $conn->query($sql);
}

// --- SEEDING ORDERS ---
$orders = [
  [1, 230000, "shipped"] // User 1's order
];

foreach ($orders as $order) {
  $sql = "INSERT INTO orders (user_id, total_price, status) 
            VALUES ($order[0], $order[1], '$order[2]')";
  $conn->query($sql);
}

// --- SEEDING ORDER ITEMS ---
$order_items = [
  [1, 1, 2, 150000],  // 2x "کلیدر" at 150000 each
  [1, 2, 1, 80000]    // 1x "بوف کور" at 80000
];

foreach ($order_items as $item) {
  $sql = "INSERT INTO order_items (order_id, shopkeeper_book_id, quantity, price_at_purchase) 
            VALUES ($item[0], $item[1], $item[2], $item[3])";
  $conn->query($sql);
}

// Close connection
$conn->close();
echo "✅ Database seeding completed successfully!";
