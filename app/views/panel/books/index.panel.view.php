<?=
load_partial('top-layout', [
  'page_title' => 'پنل | مدیریت کتب | همهٔ کتب',
]);
?>

<?php load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>

<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3 ps-0">
    <?php load_component('alert') ?>
    <div class="flex gap-2">
      <h1 class="font-extrabold text-4xl">
        مدیریت همهٔ کتب
      </h1>
    </div>
    <section class="overflow-x-auto mt-4 w-full">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th></th>
            <th>کد کتاب</th>
            <th>کد فروشنده</th>
            <th>نام فروشنده</th>
            <th>ایمیل فروشنده</th>
            <th>نام کتاب</th>
            <th>نویسنده</th>
            <th>دسته‌بندی‌ها</th>
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
                  <?php if ($book->status != "rejected") : ?>
                    <div class="tooltip tooltip-primary" data-tip="ویرایش">
                      <a href="/panel/manage/books/<?= $book->shopkeeper_id ?>/edit/<?= $book->shopkeeper_book_id ?>" class="btn btn-primary btn-sm btn-square">
                        <img src="<?= load_icon('edit') ?>" class="size-4" />
                      </a>
                    </div>
                  <?php endif; ?>
                  <?php if ($book->status == "pending") : ?>
                    <form action="/book/<?= $book->shopkeeper_book_id ?>/approve" method="post" id="approveBookForm<?= $book->shopkeeper_book_id ?>" class="hidden"></form>
                    <form action="/book/<?= $book->shopkeeper_book_id ?>/reject" method="post" id="rejectBookForm<?= $book->shopkeeper_book_id ?>" class="hidden"></form>

                    <div class="tooltip tooltip-success" data-tip="تایید">
                      <button class="btn btn-success btn-sm btn-square" onclick="document.getElementById('approveBookForm<?= $book->shopkeeper_book_id ?>').submit()">
                        <img src="<?= load_icon('check') ?>" class="size-5" />
                      </button>
                    </div>
                    <div class="tooltip tooltip-error" data-tip="رد">
                      <button class="btn btn-error btn-sm btn-square" onclick="document.getElementById('rejectBookForm<?= $book->shopkeeper_book_id ?>').submit()">
                        <img src="<?= load_icon('x') ?>" class="size-5" />
                      </button>
                    </div>
                  <?php endif; ?>
                  <?php if ($book->status == "approved") : ?>
                    <form action="/book/<?= $book->shopkeeper_book_id ?>/stop" method="post" id="stopBookForm<?= $book->shopkeeper_book_id ?>" class="hidden"></form>

                    <div class="tooltip tooltip-secondary" data-tip="توقف فروش">
                      <button class="btn btn-secondary btn-sm btn-square" onclick="document.getElementById('stopBookForm<?= $book->shopkeeper_book_id ?>').submit()">
                        <img src="<?= load_icon('pause') ?>" class="size-5" />
                      </button>
                    </div>
                  <?php endif; ?>
                  <?php if ($book->status == "stopped") : ?>
                    <form action="/book/<?= $book->shopkeeper_book_id ?>/resume" method="post" id="resumeBookForm<?= $book->shopkeeper_book_id ?>" class="hidden"></form>

                    <div class="tooltip tooltip-accent" data-tip="از سر گیری فروش">
                      <button class="btn btn-accent btn-sm btn-square" onclick="document.getElementById('resumeBookForm<?= $book->shopkeeper_book_id ?>').submit()">
                        <img src="<?= load_icon('refresh') ?>" class="size-4" />
                      </button>
                    </div>
                  <?php endif; ?>
                </td>
                <td class="text-nowrap"><?= convert_to_persian_numbers($book->book_id) ?></td>
                <td class="text-nowrap"><?= convert_to_persian_numbers($book->shopkeeper_id) ?></td>
                <td class="text-nowrap"><?= $book->shopkeeper_name ?></td>
                <td class="text-nowrap"><?= $book->shopkeeper_email ?></td>
                <td class="text-nowrap"><?= $book->title ?></td>
                <td class="text-nowrap"><?= $book->author ?></td>
                <td class="text-nowrap"><?= $book->categories ?></td>
                <td class="text-nowrap"><?= $book->isbn ?></td>
                <td class="text-nowrap"><?= $book->published_at ?></td>
                <td class="text-nowrap"><?= format_price($book->price) ?></td>
                <td class="text-nowrap"><?= convert_to_persian_numbers($book->stock) ?> جلد</td>

                <!-- TODO: put this into badge -->
                <td class="text-nowrap"><?= status_translator($book->status) ?></td>

                <!-- TODO: may be move this to the first column???? -->
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="14" class="font-bold text-base-300 text-center">عجیبه! کتابی وجود نداره!</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>

  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>