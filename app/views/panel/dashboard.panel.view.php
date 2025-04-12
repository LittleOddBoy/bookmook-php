<?php

use Framework\Session; ?>
<?=
load_partial('top-layout', [
  'page_title' => 'پنل | داشبورد',
]);
?>

<?php load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>


<main class="p-4 w-full min-h-full">
  <?= load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <?php load_component('alert') ?>
    <h1 class="font-extrabold text-4xl">
      <?= Session::get('user_data')['fullname'] ?>
      عزیز، خوش آمدید!
    </h1>
    <?= d(Session::get('user_data')) ?>
    <?= d(Session::get('authorized')) ?>
  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>