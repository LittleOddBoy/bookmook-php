<?php

use Framework\Session; ?>

<div class="relative w-3/12 flex flex-col justify-between">
  <div class="pt-7 ps-4">
    <div>
      <h1 class="text-4xl font-black ">
        پنل —
        بوک موک
      </h1>
    </div>
    <hr class="border-base-300/20 mt-4">
    <div class="mt-4 overflow-y-auto h-[450px]">
      <ul>
        <li>
          <a href="/panel/dashboard" class="btn btn-primary btn-lg p-0 items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/dashboard" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
            <img src="<?= load_icon('home') ?>">
            <span class="mt-1">داشبورد</span>
          </a>
        </li>
        <?php if (in_array(Session::get('user_data')['role'], ['shopkeeper', 'admin', 'owner'])) : ?>
          <li>
            <div class="collapse collapse-arrow py-0">
              <input type="checkbox" <?= str_contains($_SERVER['REQUEST_URI'], "/panel/manage/books") ? 'checked' : '' ?> />
              <div class="collapse-title text-lg font-semibold flex gap-2 px-0">
                <img src="<?= load_icon('book') ?>">
                <span>
                  مدیریت کتب
                </span>
              </div>
              <div class="collapse-content text-sm p-0 border-s border-secondary">
                <ul>
                  <?php if (in_array(Session::get('user_data')['role'], ['admin', 'owner'])) : ?>
                    <li>
                      <a href="/panel/manage/books" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/manage/books" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                        <img src="<?= load_icon('book-open') ?>">
                        <span class="mt-1 text-nowrap line-clamp-1">همهٔ کتب</span>
                      </a>
                    </li>
                    <li>
                      <a href="/panel/manage/books/approved" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/manage/books/approved" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                        <img src="<?= load_icon('book-open') ?>">
                        <span class="mt-1 text-nowrap line-clamp-1">کتب تایید شده</span>
                      </a>
                    </li>
                    <li>
                      <a href="/panel/manage/books/pending" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/manage/books/pending" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                        <img src="<?= load_icon('book-open') ?>">
                        <span class="mt-1 text-nowrap line-clamp-1">درخواست تایید</span>
                      </a>
                    </li>
                    <li>
                      <a href="/panel/manage/books/stopped" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/manage/books/stopped" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                        <img src="<?= load_icon('book-open') ?>">
                        <span class="mt-1 text-nowrap line-clamp-1">متوقف شده‌ها</span>
                      </a>
                    </li>
                    <li>
                      <a href="/panel/manage/books/rejected" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/manage/books/rejected" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                        <img src="<?= load_icon('book-open') ?>">
                        <span class="mt-1 text-nowrap line-clamp-1">رد شده‌ها</span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if (Session::get('user_data')['role'] == 'shopkeeper') : ?>
                    <li>
                      <a href="/panel/manage/books/<?= Session::get('user_data')['user_id'] ?>" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/manage/books/" . Session::get('user_data')['user_id'] ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                        <img src="<?= load_icon('bookmark') ?>">
                        <span class="mt-1 text-nowrap line-clamp-1">لیست کتاب‌های شما</span>
                      </a>
                    </li>
                    <li>
                      <a href="/panel/manage/books/<?= Session::get('user_data')['user_id'] ?>/add" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/manage/books/" . Session::get('user_data')['user_id'] . '/add' ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                        <img src="<?= load_icon('bookmark-plus') ?>">
                        <span class="mt-1 text-nowrap line-clamp-1">کتاب جدید</span>
                      </a>
                    </li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </li>
        <?php endif; ?>
        <?php if (in_array(Session::get('user_data')['role'], ['owner', 'admin'])) : ?>
          <li>
            <div class="collapse collapse-arrow">
              <input type="checkbox" <?= str_contains($_SERVER['REQUEST_URI'], "/panel/requests/") ? 'checked' : '' ?> />
              <div class="collapse-title text-lg font-semibold flex gap-2 px-0">
                <img src="<?= load_icon('inbox') ?>" />
                <span>
                  مدیریت درخواست‌ها
                </span>
              </div>
              <div class="collapse-content text-sm p-0 border-s border-secondary">
                <ul>
                  <li>
                    <a href="/panel/requests/to-be-shopkeeper" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/requests/to-be-shopkeeper" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                      <img src="<?= load_icon('users') ?>">
                      <span class="mt-1 text-nowrap line-clamp-1">فروشندگی</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          <li>
            <div class="collapse collapse-arrow">
              <input type="checkbox" <?= str_contains($_SERVER['REQUEST_URI'], "/panel/manage/campaigns") ? 'checked' : '' ?> />
              <div class="collapse-title text-lg font-semibold flex gap-2 px-0">
                <img src="<?= load_icon('percentage-primary-content') ?>">
                <span>
                  مدیریت کمپین‌ها
                </span>
              </div>
              <div class="collapse-content text-sm p-0 border-s border-secondary">
                <ul>
                  <li>
                    <a href="/panel/manage/campaigns" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/manage/campaigns" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                      <img src="<?= load_icon('percentage-primary-content') ?>">
                      <span class="mt-1 text-nowrap line-clamp-1">لیست کمپین‌ها</span>
                    </a>
                  </li>
                  <li>
                    <a href="/panel/manage/campaigns/add" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/manage/campaigns/create" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                      <img src="<?= load_icon('percentage-primary-content') ?>">
                      <span class="mt-1 text-nowrap line-clamp-1">کمپین جدید</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </li>
        <?php endif; ?>
        <?php if (Session::get('user_data')['role'] == 'owner') : ?>
          <li>
            <div class="collapse collapse-arrow">
              <input type="checkbox" <?= str_contains($_SERVER['REQUEST_URI'], '/panel/users') ? 'checked' : '' ?> />
              <div class="collapse-title text-lg font-semibold flex gap-2 px-0">
                <img src="<?= load_icon('users-group') ?>">
                <span>
                  مدیریت کاربران
                </span>
              </div>
              <div class="collapse-content text-sm p-0 border-s border-secondary">
                <ul>
                  <li>
                    <a href="/panel/users" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/users" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                      <img src="<?= load_icon('users') ?>">
                      <span class="mt-1">لیست کاربران</span>
                    </a>
                  </li>
                  <li>
                    <a href="/panel/users/create" class="btn btn-lg btn-primary items-center justify-start btn-wide <?= $_SERVER['REQUEST_URI'] == "/panel/users/create" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
                      <img src="<?= load_icon('user-plus') ?>">
                      <span class="mt-1">افزودن کاربر جدید</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          <li>
            <a href="/panel/settings" class="btn btn-lg btn-primary items-center justify-start btn-wide px-0 <?= $_SERVER['REQUEST_URI'] == "/panel/settings" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
              <img src="<?= load_icon('cog-three') ?>">
              <span class="mt-1">تنظیمات سایت</span>
            </a>
          </li>
        <?php endif; ?>
        <li>
          <a href="/panel/user/<?= Session::get('user_data')['user_id'] ?>/edit" class="btn btn-lg btn-primary items-center justify-start btn-wide px-0 <?= $_SERVER['REQUEST_URI'] == "/panel/user/" . Session::get('user_data')['user_id'] . "/edit" ? 'underline decoration-secondary decoration-wavy' : '' ?>">
            <img src="<?= load_icon('edit') ?>">
            <span class="mt-1">ویرایش اطلاعات شخصی</span>
          </a>
        </li>
        <li>
          <a href="/panel/order-history" class="btn btn-lg btn-primary items-center justify-start btn-wide px-0 <?= $_SERVER['REQUEST_URI'] == '/panel/order-history' ? 'underline decoration-secondary decoration-wavy' : '' ?>">
            <img src="<?= load_icon('cart-check') ?>">
            <span class="mt-1">تاریخچهٔ دریافتی‌ها</span>
          </a>
        </li>
        <?php if (Session::get("user_data")['role'] == "owner") : ?>
          <li>
            <a href="/panel/messages" class="btn btn-lg btn-primary items-center justify-start btn-wide px-0 <?= $_SERVER['REQUEST_URI'] == '/panel/messages' ? 'underline decoration-secondary decoration-wavy' : '' ?>">
              <img src="<?= load_icon('chat-messages') ?>">
              <span class="mt-1">پیام‌ها</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
  <div class="absolute bottom-0 py-7 px-4 w-full">
    <hr class="border-base-300/20">
    <ul>
      <li>
        <a href="/" class="btn btn-lg btn-primary items-center justify-start btn-wide px-0">
          <img src="<?= load_icon('arrow-up-right') ?>">
          <span class="mt-1">صفحهٔ اصلی</span>
        </a>
      </li>
      <li>
        <a href="/books" class="btn btn-lg btn-primary items-center justify-start btn-wide px-0">
          <img src="<?= load_icon('arrow-up-right') ?>">
          <span class="mt-1">کتاب‌ها</span>
        </a>
      </li>
      <li>
        <a href="/cart/<?= Session::get('user_data')['user_id'] ?>" class="btn btn-lg btn-primary items-center justify-start btn-wide px-0">
          <img src="<?= load_icon('arrow-up-right') ?>">
          <span class="mt-1">سبد خرید</span>
        </a>
      </li>
      <?php if (Session::get('user_data')['role'] == 'user') : ?>
        <li>
          <a href="/panel/requests/<?= Session::get('user_data')['user_id'] ?>/to-be-shopkeeper" class="btn btn-lg btn-secondary pe-0 text-secondary-content items-center justify-start btn-wide">
            <img src="<?= load_icon('shooting-star') ?>">
            <span class="mt-1">درخواست فروشندگی</span>
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</div>