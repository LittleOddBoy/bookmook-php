<?php

use Framework\Session; ?>
<?= load_partial('top-layout', ['page_title' => 'پیش نمایش سفارش شما', 'body_styles' => "h-dvh flex justify-between flex-col"]) ?>
<div>
  <?= load_partial('header', ['show_top_header' => false]) ?>

  <main class="space-y-36 px-20 py-8">
    <section class="space-y-4">
      <div>
        <div class="text-center">
          <h1 class="font-extrabold text-4xl">
            پیش نمایش سفارش شما
          </h1>
          <p>می‌خواهیم مطمئن شویم چیزی را از دست نمی‌دهید!</p>
        </div>
      </div>
      <div class="w-1/2 mx-auto flex justify-center overflow-x-auto border-y-2 border-base-300/50">
        <table class="table table-zebra">
          <thead>
            <tr>
              <th>#</th>
              <th>نام کتاب</th>
              <th>قیمت</th>
              <th>جمع کل</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($overall as $i => $item) : ?>
              <tr>
                <th><?= convert_to_persian_numbers($i + 1) ?></th>
                <td><?= $item->title ?></td>
                <td><?= format_price($item->price) ?></td>
                <td>
                  <span class="underline decoration-wavy decoration-secondary">
                    <?= format_price($item->total_price_per_item) ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr class="bg-accent text-accent-content">
              <td>جمع کل</td>
              <td></td>
              <td></td>
              <td class="bg-secondary text-secondary-content"><?= format_price($total) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="w-1/2 mx-auto mt-4">
        <div class="w-1/3 mx-auto">
          <form action="/cart/<?= Session::get('user_data')['user_id'] ?>/finalize" method="post">
            <button type="submit" class="btn btn-primary w-full">
              <img src="<?= load_icon('check-success') ?>">
              <span class="mt-1">
                تکمیل خرید
              </span>
            </button>
          </form>
          <a href="/books" class="btn btn-link w-full">
            یک چیزی یادم رفت!
          </a>
        </div>
      </div>
    </section>
  </main>
</div>
<?= load_partial('footer') ?>
<?= load_partial('bottom-layout') ?>