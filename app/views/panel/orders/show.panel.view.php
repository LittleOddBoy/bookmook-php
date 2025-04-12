<?=
load_partial('top-layout', [
  'page_title' => 'پنل | جزئیات سفارش شمارهٔ ' . convert_to_persian_numbers($order_info->order_id,)
]);
?>

<?php load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>


<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <div class="prose max-w-full">
      <h1 class="font-extrabold text-4xl">
        جزئیات سفارش شمارهٔ <?= convert_to_persian_numbers($order_info->order_id) ?>
      </h1>
      <section>
        <div>
          <h2>جزئیات سفارش</h2>
          <ul>
            <li>
              <span class="font-bold">
                شمارهٔ سفارش:
              </span>
              <?= convert_to_persian_numbers($order_info->order_id) ?>
            </li>
            <li>
              <span class="font-bold">
                نام مشتری:
              </span>
              <?= $order_info->customer_name ?>
            </li>
            <li>
              <span class="font-bold">
                قیمت کلی:
              </span>
              <?= format_price($order_info->total_price) ?>
            </li>
            <li>
              <span class="font-bold">
                وضعیت سفارش:
              </span>
              <?= status_translator($order_info->status) ?>
            </li>
            <li>
              <span class="font-bold">
                تاریخ سفارش:
              </span>
              <?= convert_to_persian_numbers($order_info->order_date) ?>
            </li>
          </ul>
        </div>
      </section>
      <section>
        <div>
          <h2>آیتم‌های درون سفارش</h2>
          <div class="grid grid-cols-2 gap-4">
            <?php foreach ($order_items as $item) : ?>
              <div class="bg-secondary text-secondary-content p-4">
                <ul>
                  <li>
                    <span class="font-bold">نام کتاب:</span>
                    <?= $item->book_title ?>
                  </li>
                  <li>
                    <span class="font-bold">نویسندهٔ کتاب:</span>
                    <?= $item->book_author ?>
                  </li>
                  <li>
                    <span class="font-bold">شابک (ISBN):</span>
                    <?= $item->isbn ?? "ثبت نشده است!" ?>
                  </li>
                  <li>
                    <span class="font-bold">نام فروشنده:</span>
                    <?= $item->shopkeeper_name ?>
                  </li>
                  <li>
                    <span class="font-bold">تعداد:</span>
                    <?= convert_to_persian_numbers($item->quantity) ?> جلد
                  </li>
                  <li>
                    <span class="font-bold">قیمت هر جلد در زمان خرید:</span>
                    <?= format_price($item->price_at_purchase) ?>
                  </li>
                </ul>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    </div>
    <section class="mt-4">
      <a href="/panel/order-history" class="btn btn-primary">بازگشت به تاریخچهٔ سفارشات</a>
    </section>
  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>