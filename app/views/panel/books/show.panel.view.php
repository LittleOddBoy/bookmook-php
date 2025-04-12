<?=
load_partial('top-layout', [
  'page_title' => 'پنل | کتاب‌های شما',
]);
?>

<?php

use Framework\Session;

load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>

<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <?php load_component('alert') ?>
    <div class="flex gap-2">
      <h1 class="font-extrabold text-4xl">
        کتاب‌های شما
      </h1>
      <a href="/panel/manage/books/<?= Session::get('user_data')['user_id'] ?>/add" class="btn btn-primary">
        <img src="<?= load_icon('plus') ?>" />
        <span>
          کتاب جدید
        </span>
      </a>
    </div>
    <section class="overflow-x-auto mt-4 w-full">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th></th>
            <th>کد کتاب</th>
            <th>نام کتاب</th>
            <th>نویسنده</th>
            <th>شابک (ISBN)</th>
            <th>تاریخ انتشار کتاب</th>
            <th>قیمت</th>
            <th>موجودی</th>
            <th>وضعیت</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($books) >= 1) : ?>
            <?php foreach ($books as $book) : ?>
              <tr>
                <td class="text-nowrap flex gap-2">
                  <div class="tooltip tooltip-primary" data-tip="ویرایش">
                    <a href="/panel/manage/books/<?= Session::get('user_data')['user_id'] ?>/edit/<?= $book->shopkeeper_book_id ?>" class="btn btn-primary btn-sm btn-square">
                      <img src="<?= load_icon('edit') ?>" class="size-4" />
                      <!-- <span>ویرایش</span> -->
                    </a>
                  </div>

                  <?php if ($book->status == "approved") : ?>
                    <form action="/book/<?= $book->shopkeeper_book_id ?>/stop" method="post" id="stopBookForm<?= $book->shopkeeper_book_id ?>"></form>

                    <div class="tooltip tooltip-secondary" data-tip="توقف فروش">
                      <button class="btn btn-secondary btn-sm btn-square" onclick="document.getElementById('stopBookForm<?= $book->shopkeeper_book_id ?>').submit()">
                        <img src="<?= load_icon('pause') ?>" class="size-5" />
                        <!-- <span>توقف فروش</span> -->
                      </button>
                    </div>
                  <?php endif; ?>
                  <?php if ($book->status == "stopped") : ?>
                    <form action="/book/<?= $book->shopkeeper_book_id ?>/resume" method="post" id="resumeBookForm<?= $book->shopkeeper_book_id ?>"></form>

                    <div class="tooltip tooltip-accent" data-tip="از سر گیری فروش">
                      <button class="btn btn-accent btn-sm btn-square" onclick="document.getElementById('resumeBookForm<?= $book->shopkeeper_book_id ?>').submit()">
                        <img src="<?= load_icon('refresh') ?>" class="size-4" />
                        <!-- <span>از سر گیری فروش</span> -->
                      </button>
                    </div>
                  <?php endif; ?>
                </td>
                <td class="text-nowrap"><?= convert_to_persian_numbers($book->book_id) ?></td>
                <td class="text-nowrap"><?= $book->title ?></td>
                <td class="text-nowrap"><?= $book->author ?></td>
                <td class="text-nowrap"><?= $book->isbn ?></td>
                <td class="text-nowrap"><?= $book->published_at ?></td>
                <td class="text-nowrap"><?= format_price($book->price) ?></td>
                <td class="text-nowrap"><?= convert_to_persian_numbers($book->stock) ?> جلد</td>

                <!-- TODO: put this into badge -->
                <td class="text-nowrap"><?= status_translator($book->status) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="11" class="font-bold text-base-300 text-center">شما کتابی برای فروش ندارید</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>