<?php

use Framework\Session; ?>
<?=
load_partial('top-layout', [
  'page_title' => 'پنل | تنظیمات سایت',
]);
?>

<?php load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>

<!-- TODO: move it under users/ folder -->
<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <?php load_component('alert') ?>
    <h1 class="font-extrabold text-4xl">
      تنظیمات سایت
    </h1>
    <section class="mt-4">
      <form action="/settings/update" method="post">
        <div class="w-lg grid grid-cols-2 gap-y-2">
          <label for="site_email" class="label">
            ایمیل سایت
          </label>
          <input
            type="email"
            name="site_email"
            id="site_email"
            class="input input-secondary"
            value="<?= $settings->site_email ?>">

          <label for="contact_number" class="label">
            شماره تماس سایت
          </label>
          <input type="tel" name="contact_number" id="contact_number" class="input input-secondary" value="<?= $settings->contact_number ?>">

          <label for=" address" class="label">
            آدرس
          </label>
          <input type="text" name="address" id="address" class="input input-secondary" value="<?= $settings->address ?>">
        </div>
        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <img src="<?= load_icon('check-success') ?>">
            <span>
              به روز رسانی تنظیمات
            </span>
          </button>
          <button type="reset" class="group btn btn-error btn-outline">
            <img src="<?= load_icon('refresh-error') ?>" class="group-hover:hidden">
            <img src="<?= load_icon('refresh') ?>" class="hidden group-hover:block">
            <span>بازگردانی</span>
          </button>
        </div>
      </form>
    </section>
  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>