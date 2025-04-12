<?php

use Framework\Session; ?>
<?=
load_partial('top-layout', [
  'page_title' => 'پنل | درخواست برای فروشندگی',
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
        درخواست برای فروشندگی
      </h1>
      <a href="/panel/requests/<?= Session::get('user_data')['user_id'] ?>/to-be-shopkeeper/request" class="btn btn-primary">
        <img src="<?= load_icon('plus') ?>" />
        <span>
          درخواست جدید
        </span>
      </a>
    </div>
    <section class="mt-4">
      <table class="table table-zebra">
        <!-- head -->
        <thead>
          <tr>
            <th>کد درخواست</th>
            <th>نام فروشگاه</th>
            <th>وضعیت درخواست</th>
            <th>تاریخ درخواست</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($requests) >= 1) : ?>
            <?php foreach ($requests as $req) : ?>
              <tr>
                <td><?= convert_to_persian_numbers($req->id) ?></td>
                <td><?= $req->shop_name ?></td>
                <td>
                  <div class="badge badge-accent">
                    <?= status_translator($req->status) ?>
                  </div>
                </td>
                <td><?= $req->created_at ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="4" class="font-bold text-base-300 text-center">هنوز درخواستی ثبت نکردید</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>

  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>