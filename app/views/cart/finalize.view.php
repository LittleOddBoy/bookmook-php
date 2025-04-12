<?= load_partial('top-layout', ['page_title' => 'مبارک است!', 'body_styles' => "h-dvh flex justify-between flex-col"]) ?>
<div>
  <?= load_partial('header') ?>

  <main class="space-y-36 px-20 py-8">
    <section class="w-full mx-auto flex justify-center">
      <div class="w-1/2 space-y-4">
        <div class="text-center">
          <h1 class="font-extrabold text-4xl">
            با موفقیت انجام شد!
          </h1>
        </div>
        <hr class="border-base-300/50">
        <div class="text-center space-y-2">
          <p>
            سفارش شما با موفقیت ثبت شد. مبارکتان باشد!
          </p>
          <a href="/books" class="btn btn-link">برو به «کتاب‌ها»</a>
        </div>
      </div>
    </section>
  </main>
</div>
<?= load_partial('footer') ?>
<?= load_partial('bottom-layout') ?>