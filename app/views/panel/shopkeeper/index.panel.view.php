<?=
load_partial('top-layout', [
  'page_title' => 'پنل | درخواست‌‌ها | درخواست‌های فروشندگی',
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
        درخواست‌ها برای فروشندگی
      </h1>
    </div>
    <section class="overflow-x-auto mt-4 w-full">
      <table class="table table-zebra">
        <!-- head -->
        <thead>
          <tr>
            <th></th>
            <th>کد درخواست</th>
            <th>کد کاربر</th>
            <th>نام کاربر</th>
            <th>ایمیل کاربر</th>
            <th>نام فروشگاه</th>
            <th>آدرس فروشگاه</th>
            <th>ایمیل فروشگاه</th>
            <th>وضعیت درخواست</th>
            <th>تاریخ درخواست</th>
          </tr>
        </thead>
        <tbody>
          <!-- TODO: make sure you handle all the edge cases where 0 items is possible -->
          <?php if (count($requests) >= 1) : ?>
            <?php foreach ($requests as $req) : ?>
              <tr>
                <td class="text-nowrap">
                  <?php if (!in_array($req->status, ['approved', 'rejected'])) : ?>
                    <form class="hidden" action="/shopkeeper/<?= $req->request_id ?>/approve" method="post" id="approveRequestForm<?= $req->request_id ?>"></form>
                    <div class="tooltip tooltip-primary" data-tip="تایید">
                      <button class="btn btn-primary btn-sm btn-square" onclick="document.getElementById('approveRequestForm<?= $req->request_id ?>').submit()">
                        <img src="<?= load_icon('check-success') ?>" />
                      </button>
                    </div>

                    <form action="/shopkeeper/<?= $req->request_id ?>/reject" method="post" class="hidden" id="rejectRequestForm<?= $req->request_id ?>"></form>
                    <div class="tooltip tooltip-error" data-tip="رد">
                      <button class="btn btn-error btn-sm btn-square" onclick="document.getElementById('rejectRequestForm<?= $req->request_id ?>').submit()">
                        <img src="<?= load_icon('x') ?>" />
                      </button>
                    </div>
                  <?php endif; ?>
                </td>
                <td class="text-nowrap"><?= convert_to_persian_numbers($req->request_id) ?></td>
                <td class="text-nowrap"><?= convert_to_persian_numbers($req->user_id) ?></td>
                <td class="text-nowrap"><?= $req->user_fullname ?></td>

                <!-- TODO: mailto links -->
                <td class="text-nowrap"><?= $req->user_email ?></td>
                <td class="text-nowrap"><?= $req->shop_name ?></td>
                <td class="text-nowrap"><?= $req->address ?></td>
                <td class="text-nowrap"><?= $req->commercial_email ?></td>
                <td class="text-nowrap">
                  <div class="badge badge-accent">
                    <?= status_translator($req->status) ?>
                  </div>
                </td>
                <td class="text-nowrap"><?= $req->created_at ?></td>
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