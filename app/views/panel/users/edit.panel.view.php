<?=
load_partial('top-layout', [
  'page_title' => 'پنل | ویرایش اطلاعات',
]);
?>

<?php load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>

<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <?php load_component('alert') ?>
    <h1 class="font-extrabold text-4xl">
      ویرایش اطلاعات
    </h1>
    <section class="mt-2">
      <form action="/user/update" method="post">
        <div class="w-lg grid grid-cols-2 gap-y-2 items-start">
          <label for="fullname" class="label">
            نام و نام خانوادگی
          </label>
          <input
            type="text"
            name="fullname"
            id="fullname"
            class="input input-secondary"
            value="<?= $user->fullname ?>">

          <label for="email" class="label">
            ایمیل
          </label>
          <input type="email" name="email" id="email" class="input input-secondary" value="<?= $user->email ?>">

          <label for="phone" class="label">
            شمارهٔ تلفن
          </label>
          <input type="tel" name="phone" id="phone" class="input input-secondary" value="<?= $user->phone ?>" placeholder="لطفا شماره تلفن ایرانی وارد کنید">

          <label for="address" class="label">آدرس</label>
          <textarea
            class="textarea textarea-lg h-82 w-full"
            name="address"
            id="address"
            placeholder="آدرس محل زندگی خود را برایمان بنویسید..."><?= $user->address ?? '' ?></textarea>
        </div>
        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <img src="<?= load_icon('check-success') ?>">
            <span>
              به روز رسانی اطلاعات
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