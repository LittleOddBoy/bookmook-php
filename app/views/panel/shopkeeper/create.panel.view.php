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
    <div>
      <h1 class="font-extrabold text-4xl">
        درخواست جدید برای فروشندگی
      </h1>
      <p class="mt-2 w-8/12">
        بوک‌موک جایی برای رشد است. با بازار سرشار از مشتری ما می‌توانید آیندهٔ شغلی خوبی داشته باشید. ما بسیار خوشحالیم که می‌خواهید برای فروشندگی اقدام کنید! لطفا اطلاعات صحیح و اداری فروشگاه خود را برای ما وارد کنید تا ما درخواست شما را در اسرع وقت بررسی کنیم!
      </p>
    </div>
    <section class="mt-4">
      <form action="/shopkeeper/request" method="post">
        <div class="w-lg grid grid-cols-2 gap-y-2">
          <label for="shop_name" class="label">
            نام فروشگاه
          </label>
          <input
            type="text"
            name="shop_name"
            id="shop_name"
            class="input input-secondary">

          <label for="commercial_email" class="label">
            ایمیل فروشگاه
          </label>
          <input type="email" name="commercial_email" id="commercial_email" class="input input-secondary">

          <label for="address" class="label">
            آدرس فروشگاه
          </label>
          <input type="text" name="address" id="address" class="input input-secondary">
        </div>
        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <img src="<?= load_icon('check-success') ?>">
            <span>
              ثبت درخواست
            </span>
          </button>
          <button type="reset" class="group btn btn-error btn-outline">
            <img src="<?= load_icon('delete-error') ?>" class="group-hover:hidden">
            <img src="<?= load_icon('delete') ?>" class="hidden group-hover:block">
            <span>پاک کردن</span>
          </button>
        </div>
      </form>
    </section>

  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>