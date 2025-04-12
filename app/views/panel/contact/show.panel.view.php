<?=
load_partial('top-layout', [
  'page_title' => 'پنل | پیام‌ها | جزئیات پیام شمارهٔ ' . convert_to_persian_numbers($message->id),
]);
?>

<?php
load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>


<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <?php load_component('alert') ?>
    <div class="flex gap-4">
      <h1 class="font-extrabold text-4xl">
        جزئیات پیام شمارهٔ <?= convert_to_persian_numbers($message->id) ?>
      </h1>
    </div>
    <section class="mt-4">
      <form action="/user/create" method="post">
        <div class="w-lg grid grid-cols-2 gap-y-2">
          <span>نام و نام خانودگی:‌</span>
          <span><?= $message->fullname ?></span>

          <span>ایمیل:</span>
          <span><?= $message->email ?></span>

          <span>پیام:</span>
          <span><?= $message->message ?></span>
        </div>
      </form>
    </section>
    <section class="mt-4">
      <a href="/panel/messages" class="btn btn-primary">بازگشت به پیام‌ها</a>
    </section>
  </div>
</main>

<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>