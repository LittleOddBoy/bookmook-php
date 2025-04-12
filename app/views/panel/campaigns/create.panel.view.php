<?=
load_partial('top-layout', [
  'page_title' => 'پنل | مدیریت کمپین‌ها | شروع کمپین جدید',
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
        شروع کمپین جدید
      </h1>
    </div>
    <section class="overflow-x-auto mt-4 w-full">
      <form action="/campaign/start" method="post">
        <div class="w-lg grid grid-cols-2 gap-y-2 items-start">
          <label for="name" class="label">نام کمپین</label>
          <input type="text" name="name" id="name" class="input input-secondary">
          <?php if (isset($errors['name']) and !empty($errors['name'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['name'] ?></span>
            </div>
          <?php endif; ?>

          <label for="description" class="label">توضیحات کمپین</label>
          <input type="text" name="description" id="description" class="input input-secondary">
          <?php if (isset($errors['description']) and !empty($errors['description'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['description'] ?></span>
            </div>
          <?php endif; ?>

          <label for="start_date" class="label">تاریخ شروع</label>
          <input type="date" name="start_date" id="start_date" class="input input-secondary">
          <?php if (isset($errors['start_date']) and !empty($errors['start_date'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['start_date'] ?></span>
            </div>
          <?php endif; ?>

          <label for="end_date" class="label">تاریخ پایان</label>
          <input type="date" name="end_date" id="end_date" class="input input-secondary">
          <?php if (isset($errors['end_date']) and !empty($errors['end_date'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['end_date'] ?></span>
            </div>
          <?php endif; ?>
        </div>
        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <img src="<?= load_icon('check-success') ?>">
            <span>
              شروع کمپین
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