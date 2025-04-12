<?=
load_partial('top-layout', [
  'page_title' => 'پنل | مدیریت کتب | کتب رد شده',
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
        مدیریت کتب رد شده
      </h1>
    </div>
    <section class="overflow-x-auto mt-4 w-full">
      <table class="table table-zebra">
        <thead>
          <tr>
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
          </tr>
        </thead>
        <tbody>
          <?php if (count($books) >= 1) : ?>
            <?php foreach ($books as $book) : ?>
              <tr>
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