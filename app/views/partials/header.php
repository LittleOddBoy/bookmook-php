<?php

use Framework\Database;
use Framework\Session;

$config = require(base_path('config/db.php'));
$db = new Database($config);

$campaigns_query = "SELECT id AS campaign_id, name FROM campaigns";
$campaigns = $db->fetch_all_as_object($campaigns_query);

?>
<!-- header -->
<header
  class="border-b-base-300 bg-base-200 sticky -top-20 z-50 space-y-4 border-b px-20 py-5">
  <!-- top header -->
  <?php if (!isset($show_top_header) or $show_top_header) : ?>
    <section class="flex items-center justify-between">
      <ul class="flex space-x-5">
        <li>
          <a href="/about-project" class="hover:link hover:link-secondary">
            دربارهٔ پروژهٔ بوک‌موک
          </a>
        </li>
        <li>
          <a
            href=""
            title="درحال حاضر، این بخش در حالت توسعه است."
            class="opacity-20">مشاغل</a>
        </li>
        <li>
          <a href="" class="hover:link hover:link-secondary">وبلاگ</a>
        </li>
      </ul>
      <ul class="flex space-x-5">
        <?php if (!Session::get('authorized')) : ?>
          <li>
            <a href="/auth/login" class="btn btn-accent btn-outline">ورود</a>
          </li>
          <li>
            <a href="/auth/signin" class="btn btn-primary">ثبت نام</a>
          </li>
        <?php endif; ?>
        <?php if (Session::get('authorized')) : ?>
          <li class="group">
            <a
              href="/panel/dashboard"
              class="btn btn-ghost btn-square transition duration-300 ease-in-out group-hover:btn-wide group-hover:text-primary-content group-hover:bg-primary group-hover:px-2">
              <span class="hidden group-hover:block"> <?= Session::get('user_data')['fullname'] ?> </span>
              <img src="<?= load_icon('user') ?>" class="group-hover:hidden" />
              <img
                src="<?= load_icon('user-retro') ?>"
                class="hidden group-hover:block" />
            </a>
          </li>
          <li>
            <a href="/cart/<?= Session::get('user_data')['user_id'] ?>" class="btn btn-ghost btn-square">
              <img src="<?= load_icon('cart') ?>" />
            </a>
          </li>
        <?php endif; ?>
        <li>
          <a href="/search" class="btn btn-ghost btn-square">
            <img src="<?= load_icon('search') ?>" />
          </a>
        </li>
      </ul>
    </section>
    <hr class="border-base-300" />
  <?php endif; ?>


  <!-- bottom header -->
  <section class="flex items-center justify-between">
    <div>
      <a href="/">
        <img
          src="<?= load_assets('images/transparent/logo-green-text.png') ?>"
          class="w-40" />
      </a>
    </div>
    <div>
      <ul class="flex">
        <li>
          <a
            href="/"
            class="btn <?= $_SERVER['REQUEST_URI'] == '/' ? 'btn-secondary font-bold' : 'btn-ghost' ?>">صفحه اصلی</a>
        </li>
        <li>
          <a href="/books" class="btn <?= $_SERVER['REQUEST_URI'] == '/books' ? 'btn-secondary font-bold' : 'btn-ghost' ?>">کتاب‌ها</a>
        </li>
        <li>
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn <?= str_contains($_SERVER['REQUEST_URI'], '/campaigns/') ? 'btn-secondary font-bold' : 'btn-ghost' ?>" <?= count($campaigns) == 0 ? 'disabled' : '' ?>>جشنواره‌ها</div>
            <ul
              tabindex="0"
              class="menu dropdown-content bg-base-200 rounded-box z-1 mt-4 w-52 p-2 shadow-sm">
              <?php foreach ($campaigns as $c) : ?>
                <li>
                  <a href="/campaigns/<?= $c->campaign_id ?>" class="<?= $_SERVER['REQUEST_URI'] == "/campaigns/{$c->campaign_id}" ? 'font-bold bg-base-300' : '' ?>"><?= $c->name ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>
        <li>
          <a href="/contact-us" class="btn <?= $_SERVER['REQUEST_URI'] == "/contact-us" ? 'btn-secondary font-bold' : 'btn-ghost' ?>">تماس با ما</a>
        </li>
        <li>
          <a href="/about-us" class="btn <?= $_SERVER['REQUEST_URI'] == "/about-us" ? 'btn-secondary font-bold' : 'btn-ghost' ?>">درباره ما</a>
        </li>
      </ul>
    </div>
  </section>
</header>