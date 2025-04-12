<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Framework\Validation;

class UserController
{
  protected $db;
  public function __construct()
  {
    $config = require(base_path('config/db.php'));
    $this->db = new Database($config);
  }

  public function index(): void
  {
    $all_users_query = " SELECT 
          user_id,
          user_fullname,
          user_email,
          user_role,
          created_at,
          updated_at
      FROM users
      ORDER BY user_role DESC;
    ";
    $all_users = $this->db->fetch_all_as_object($all_users_query);

    load_panel_view('users/index', ['users' => $all_users]);
  }

  public function signin(): void
  {
    load_view('auth/signin');
  }

  public function login(): void
  {
    load_view('auth/login');
  }

  public function store(): void
  {
    $user_fullname = $_POST['fullname'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $user_password_confirm = $_POST['password_confirm'];

    $errors = []; // TODO: maybe doing this in a better way? I don't like to load a view for this... redirect? if possible?

    // validate email address
    if (!Validation::email($user_email)) {
      $errors['email'] = "لطفا یک آدرس ایمیل معتبر وارد بفرمایید!";
    }

    // validate name string 
    if (!Validation::string($user_fullname, min: 3, max: 50)) {
      $errors['fullname'] = "نام و نام خانوادگی باید حداقل ۳ و حداکثر ۵۰ کاراکتر باشد!";
    }

    // validate password string
    if (!Validation::string($user_password, min: 8, max: 50)) {
      $errors['password'] = "گذرواژهٔ شما باید حداقل ۸ کاراکتر و حداکثر ۵۰ کاراکتر باشد!";
    }

    // validate password and its confirmation matching
    if (!Validation::match($user_password, $user_password_confirm)) {
      $errors['password_confirm'] = "از صحت تکرار گذرواژه اطمینان حاصل کنید!";
    }

    // render the errors if they exist
    if (!empty($errors)) {
      load_view('auth/signin', [
        'errors' => $errors,
        'old_data' => [
          'user_fullname' => $user_fullname,
          'user_email' => $user_email,
        ],
      ]);
      exit;
    }

    // check if the email does exist in db
    $search_params = [$user_email];
    $existed_emails = $this->db->query("SELECT user_email FROM users WHERE user_email = ?", $search_params);

    $existed_emails = $existed_emails->fetch_assoc();

    if (isset($existed_emails) and !empty($existed_emails)) {
      $errors['email_already_exists'] = "ایمیل قبلا استفاده شده است! لطفا وارد شوید";
      load_view('auth/signin', [
        'errors' => $errors,
      ]);
      exit;
    }

    // create user account
    $create_params = [
      $user_fullname,
      $user_email,
      'user',
      password_hash($user_password, PASSWORD_DEFAULT),
    ];

    $create_user = $this->db->query(
      'INSERT INTO users (user_fullname, user_email, user_role, user_password) VALUES (?, ?, ?, ?)',
      $create_params
    );

    $user_id = $this->db->get_last_inserted_id();

    $create_user_cart = $this->db->query(
      'INSERT INTO carts (cart_user_id) VALUES (?)',
      [$user_id]
    );

    $user_cart_id = $this->db->get_last_inserted_id();

    $user_data = [
      "user_id" => $user_id,
      "user_cart_id" => $user_cart_id,
      "fullname" => $user_fullname,
      "email" => $user_email,
      "phone" => "",
      "address" => "",
      "role" => 'user',
    ];

    Session::set('user_data', $user_data);
    Session::set('authorized', true);

    redirect('/panel/dashboard');
  }

  public function logout(): void
  {
    Session::clear_all();

    $cookie_params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 86400, $cookie_params['path'], $cookie_params['domain']);

    redirect('/');
  }

  public function authenticate(): void
  {
    // get form data
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    $errors = [];

    // validate the email address
    if (!Validation::email($user_email)) {
      $errors['email'] = "لطفا یک آدرس ایمیل معتبر وارد بفرمایید!";
    }

    // validate the password string
    if (!Validation::string($user_password, min: 8, max: 50)) {
      $errors['password'] = "گذرواژهٔ شما باید حداقل ۸ کاراکتر و حداکثر ۵۰ کاراکتر باشد!";
    }

    // return to view and render errors if they exist
    if (!empty($errors)) {
      load_view('auth/login', [
        'errors' => $errors,
      ]);
      exit;
    }

    // check if such email does exist in db
    $search_params = [$user_email];
    $user = $this->db->query("SELECT * FROM users WHERE user_email = ?", $search_params);
    $user = $user->fetch_object();

    // return to view and render error if no such user does exist 
    if (!$user) {
      $errors['user_does_not_exist'] = "متاسفانه کاربری با همچین اطلاعاتی وجود ندارد. ثبت نام کنید!";
      load_view('auth/login', [
        'errors' => $errors,
      ]);
      exit;
    }

    // check if password is correct 
    if (!password_verify(password: $user_password, hash: $user->user_password)) {
      $errors['incorrect_password'] = "گذرواژه نادرست است!";
      load_view('auth/login', [
        'errors' => $errors,
      ]);
      exit;
    }

    $user_cart = $this->db->query("SELECT * FROM carts WHERE cart_user_id = ?", [$user->user_id])->fetch_object();

    $user_data = [
      'user_id' => $user->user_id,
      'user_cart_id' => $user_cart->cart_id,
      'fullname' => $user->user_fullname,
      'email' => $user->user_email,
      'phone' => $user->user_phone,
      'address' => $user->user_address,
      'role' => $user->user_role
    ];

    Session::set('user_data', $user_data);
    Session::set('authorized', true);

    redirect('/panel/dashboard');
  }

  public function edit(): void
  {
    $user_data = [
      'fullname' => Session::get('user_data')['fullname'],
      'email' => Session::get('user_data')['email'],
      'phone' => Session::get('user_data')['phone'],
      'address' => Session::get('user_data')['address'],
    ];

    $user = (object) $user_data;
    load_panel_view('users/edit', ['user' => $user]);
  }

  public function update()
  {
    $new_fullname = $_POST['fullname'];
    $new_email = $_POST['email'];
    $new_phone = $_POST['phone'];
    $new_address = $_POST['address'];

    $errors = []; // TODO: show the errors in panel view 

    if (!Validation::string($new_fullname, 3, 50)) {
      $errors['fullname'] = "نام کاربری باید حداقل ۲ و حداکثر ۵۰ کاراکتر باشد!";
    }

    if (!Validation::email($new_email)) {
      $errors['email'] = "ایمیل معتبر نمی‌باشد!";
    }

    if (!empty($errors)) {
      redirect('/panel/users/' . Session::get('user_data')['user_id'] . '/edit', ['errors' => $errors]);
      exit;
    }

    $similar_emails_params = [Session::get('user_data')['user_id'], $new_email];
    $similar_emails = $this->db->query('SELECT * FROM users WHERE user_id <> ? AND user_email = ?', $similar_emails_params)->fetch_assoc();

    if ($similar_emails and count($similar_emails) > 1) {
      $errors['similar_email'] = 'این ایمیل قبلا ثبت شده است!';
      load_panel_view('users/edit', ['errors' => $errors]);
    }

    $update_info_params = [$new_fullname, $new_email, $new_phone, $new_address, Session::get('user_data')['user_id']];
    $update_info_query = "UPDATE users SET user_fullname = ?, user_email = ?, user_phone = ?, user_address = ?, updated_at = NOW() WHERE user_id = ?";

    $update_info = $this->db->query($update_info_query, $update_info_params);

    $user_data = [
      'user_id' => Session::get('user_data')['user_id'],
      'user_cart_id' => Session::get('user_data')['user_cart_id'],
      'fullname' => $new_fullname,
      'email' => $new_email,
      'phone' => $new_phone,
      'address' => $new_address,
      'role' => Session::get('user_data')['role'],
    ];

    Session::set('user_data', $user_data);

    Session::set_flash_message('success', "اطلاعات شما با موفقیت ویرایش شد!");
    redirect('/panel/user/' . Session::get('user_data')['user_id'] . '/edit');
  }

  public function to_admin(array $params): void
  {
    $user_id = $params['user_id'];

    $to_admin_params = [$user_id];
    $to_admin_query = "UPDATE users SET user_role = 'admin' WHERE user_id = ?";

    $to_admin = $this->db->query($to_admin_query, $to_admin_params);

    Session::set_flash_message('success', 'کاربر با موفقیت به ادمین ارتقا پیدا کرد!');

    redirect('/panel/users');
  }

  public function to_user(array $params): void
  {
    $user_id = $params['user_id'];

    $to_user_params = [$user_id];
    $to_user_query = "UPDATE users SET user_role = 'user' WHERE user_id = ?";

    $to_user = $this->db->query($to_user_query, $to_user_params);

    Session::set_flash_message('success', 'کاربر با موفقیت به کاربر عادی نزول پیدا کرد!');

    redirect('/panel/users');
  }

  public function delete(array $params): void
  {
    $user_id = $params['user_id'];

    $delete_user_params = [$user_id];
    $delete_user_query = "DELETE FROM users WHERE user_id = ?";

    $delete_user = $this->db->query($delete_user_query, $delete_user_params);

    Session::set_flash_message('success', 'کاربر مورد نظر با موفقیت حذف شد!');

    redirect('/panel/users');
  }

  public function create(): void
  {
    load_panel_view('users/create');
  }

  public function create_user(): void
  {
    $new_user_fullname = $_POST['fullname'];
    $new_user_email = $_POST['email'];
    $new_user_password = $_POST['password'];
    $new_user_password_confirmation = $_POST['password_confirmation'];
    $new_user_role = $_POST['role'];


    $errors = [];

    // validate email address
    if (!Validation::email($new_user_email)) {
      $errors['email'] = "لطفا یک آدرس ایمیل معتبر وارد بفرمایید!";
    }

    // validate name string 
    if (!Validation::string($new_user_fullname, min: 3, max: 50)) {
      $errors['fullname'] = "نام و نام خانوادگی باید حداقل ۳ و حداکثر ۵۰ کاراکتر باشد!";
    }

    // validate password string
    if (!Validation::string($new_user_password, min: 8, max: 50)) {
      $errors['password'] = "گذرواژهٔ شما باید حداقل ۸ کاراکتر و حداکثر ۵۰ کاراکتر باشد!";
    }

    // validate password and its confirmation matching
    if (!Validation::match($new_user_password, $new_user_password_confirmation) or !Validation::string($new_user_password_confirmation, min: 8, max: 50)) {
      $errors['password_confirmation'] = "از صحت تکرار گذرواژه اطمینان حاصل کنید!";
    }

    // make sure the owner is not nasty!
    if (!in_array($new_user_role, ['user', 'admin', 'owner'])) {
      $errors['role'] = "نقش وارد شده برای کاربر معتبر نمی‌باشد!";
    }

    // render the errors if they exist
    if (!empty($errors)) {
      load_panel_view('users/create', [
        'errors' => $errors,
        'old_data' => [
          'fullname' => $new_user_fullname,
          'email' => $new_user_email,
          'role' => $new_user_email,
        ],
      ]);
      exit;
    }

    // check if the email does exist in db
    $search_params = [$new_user_email];
    $existed_emails = $this->db->query("SELECT user_email FROM users WHERE user_email = ?", $search_params)->fetch_object();

    if ($existed_emails) {
      $errors['email_already_exists'] = "این ایمیل قبلا ثبت شده است!";
      load_view('users/create', [
        'errors' => $errors,
      ]);
      exit;
    }

    // create user account
    $create_params = [
      $new_user_fullname,
      $new_user_email,
      $new_user_role,
      password_hash($new_user_password, PASSWORD_DEFAULT),
    ];

    $create_user = $this->db->query(
      'INSERT INTO users (user_fullname, user_email, user_role, user_password) VALUES (?, ?, ?, ?)',
      $create_params
    );

    $user_id = $this->db->get_last_inserted_id();

    $create_user_cart = $this->db->query(
      'INSERT INTO carts (cart_user_id) VALUES (?)',
      [$user_id]
    );

    Session::set_flash_message('success', 'کاربر با موفقیت ایجاد شد!');
    redirect('/panel/users');
  }
}

// TODO: check all the SELECT queries throughout the whole app, and make sure you added ->fetch_object()
