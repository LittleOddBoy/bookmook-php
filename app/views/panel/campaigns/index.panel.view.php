<?=
load_partial('top-layout', [
  'page_title' => 'پنل | مدیریت کمپین‌ها | لیست کمپین‌ها',
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
        لیست کمپین‌ها
      </h1>
      <a href="/panel/manage/campaigns/add" class="btn btn-primary">
        <img src="<?= load_icon('plus') ?>" />
        <span>شروع کمپین جدید</span>
      </a>
    </div>
    <section class="overflow-x-auto mt-4 w-full">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th></th>
            <th>نام کمپین</th>
            <th>توضیحات کمپین</th>
            <th>تاریخ شروع</th>
            <th>تاریخ پایان</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($campaigns) >= 1) : ?>
            <?php foreach ($campaigns as $c) : ?>
              <tr>
                <td class="text-nowrap flex gap-2">
                  <div class="tooltip tooltip-primary" data-tip="کتب">
                    <a href="/panel/manage/campaigns/<?= $c->campaign_id ?>/books" class="btn btn-primary btn-sm btn-square">
                      <img src="<?= load_icon('book') ?>" class="size-5" />
                    </a>
                  </div>
                </td>
                <td class="text-nowrap"><?= $c->name ?></td>
                <td class="text-nowrap"><?= $c->description ?></td>
                <td class="text-nowrap"><?= $c->start_date ?></td>
                <td class="text-nowrap"><?= $c->end_date ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="14" class="font-bold text-base-300 text-center">کمپینی بر قرار نیست!</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>