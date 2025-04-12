<?=
load_partial('top-layout', [
  'page_title' => 'پنل | پیام‌ها',
]);
?>

<?php load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>

<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <div>
      <h1 class="font-extrabold text-4xl">پیام‌ها</h1>
    </div>

    <div class="overflow-x-auto mt-4">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th></th>
            <th>نام و نام خانوادگی</th>
            <th>ایمیل</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($messages as $m) : ?>
            <tr class="relative hover:bg-base-200">
              <td>
                <div class="tooltip tooltip-secondary" data-tip="جزئیات">
                  <a href="/panel/messages/<?= $m->id ?>" class="btn btn-secondary btn-square btn-sm">
                    <img src="<?= load_icon('info') ?>" />
                  </a>
                </div>
              </td>
              <td><?= $m->fullname ?></td>
              <td><?= $m->email ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>