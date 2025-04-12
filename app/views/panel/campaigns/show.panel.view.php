<?=
load_partial('top-layout', [
  'page_title' => 'پنل | مدیریت کمپین‌ها | کتاب‌های کمپین شمارهٔ ' . convert_to_persian_numbers($campaign_id),
]);
?>

<?php load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>

<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <?php load_component('alert') ?>
    <div class="flex gap-2">
      <h1 class="font-extrabold text-4xl">
        کتاب‌های کمپین شمارهٔ <?= convert_to_persian_numbers($campaign_id) ?>
      </h1>
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
          </tr>
        </thead>
        <tbody>
          <?php if (count($books) >= 1) : ?>
            <?php foreach ($books as $book) : ?>
              <tr>
                <td class="text-nowrap flex gap-2">
                  <?php if (!$book->included_in_campaign) : ?>
                    <form action="/campaign/<?= $campaign_id ?>/books/<?= $book->book_id ?>/add" method="post" class="hidden" id="addBookToCampaignForm<?= $book->book_id ?>"></form>

                    <div class="tooltip tooltip-success" data-tip="اضافه کردن">
                      <button class="btn btn-success btn-sm btn-square" onclick="document.getElementById('addBookToCampaignForm<?= $book->book_id ?>').submit()">
                        <img src="<?= load_icon('plus') ?>" class="size-5" />
                      </button>
                    </div>
                  <?php else : ?>
                    <form action="/campaign/<?= $campaign_id ?>/books/<?= $book->book_id ?>/remove" method="post" class="hidden" id="removeBookToCampaignForm<?= $book->book_id ?>">
                      <input type="hidden" name="_method" value='DELETE'>
                    </form>

                    <div class="tooltip tooltip-error" data-tip="حذف کردن">
                      <button class="btn btn-error btn-sm btn-square" onclick="document.getElementById('removeBookToCampaignForm<?= $book->book_id ?>').submit()">
                        <img src="<?= load_icon('minus') ?>" class="size-5" />
                      </button>
                    </div>
                  <?php endif; ?>
                </td>
                <td class="text-nowrap"><?= convert_to_persian_numbers($book->book_id) ?></td>
                <td class="text-nowrap"><?= $book->title ?></td>
                <td class="text-nowrap"><?= $book->author ?></td>
                <td class="text-nowrap"><?= $book->isbn ?></td>
                <td class="text-nowrap"><?= $book->published_at ?></td>
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