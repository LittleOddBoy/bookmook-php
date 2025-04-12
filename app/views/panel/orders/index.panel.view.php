<?=
load_partial('top-layout', [
  'page_title' => 'پنل | تاریخچهٔ سفارشات',
]);
?>

<?php load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>

<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <div>
      <h1 class="font-extrabold text-4xl">تاریخچهٔ سفارشات</h1>
    </div>

    <div class="flex w-full items-center justify-between mt-4">
      <div class="flex items-center gap-1">
        <div class="bg-primary size-3"></div>
        &nbsp;
        <span class="decoration-secondary underline decoration-wavy">
          ۸
        </span>
        <span>سفارش</span>
        <span class="text-accent opacity-50">بارگیری شد.</span>
      </div>
      <div class="flex gap-8">
        <div>
          <select
            name="category_filter"
            id="category_filter"
            class="select">
            <option selected value="همه">همه</option>
            <option value="درام">درام</option>
            <option value="کلاسیک">کلاسیک</option>
            <option value="کلاسیک روسی">کلاسیک روسی</option>
            <option value="فلسفی">فلسفی</option>
          </select>
        </div>
        <div class="flex items-center gap-3">
          <div>
            <span
              class="text-accent decoration-secondary underline decoration-wavy opacity-50">مرتب سازی بر اساس</span>
          </div>
          <label class="label">
            <input
              type="radio"
              class="radio radio-accent"
              checked
              name="order"
              id="order"
              value="desc" />
            جدیدترین‌ها
          </label>
          <label class="label">
            <input
              type="radio"
              class="radio radio-accent"
              name="order"
              id="order"
              value="asc" />
            قدیمی‌ترین‌ها
          </label>
        </div>
        <div>
          <button class="btn btn-primary">
            <span> اعمال فیلترها </span>
            <img
              src="<?= load_icon('arrow-long-left-secondary-content') ?>" />
          </button>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto mt-4">
      <table class="table table-zebra">
        <!-- head -->
        <thead>
          <tr>
            <th></th>
            <th>شمراه سفارش</th>
            <th>قیمت نهایی</th>
            <th>وضعیت</th>
            <th>تاریخ تولد سفارش</th>
            <th>فروشنده</th>
            <th>تعداد آیتم‌ها</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order_history as $order) : ?>
            <tr class="relative hover:bg-base-200">
              <td>
                <div class="tooltip tooltip-secondary" data-tip="جزئیات">
                  <a href="/panel/order-history/<?= $order->order_id ?>" class="btn btn-secondary btn-sm btn-square">
                    <img src="<?= load_icon('info') ?>" />
                  </a>
                </div>
              </td>
              <th><?= convert_to_persian_numbers($order->order_id) ?></th>
              <td><?= format_price($order->total_price) ?></td>
              <td>
                <div class="badge badge-accent">
                  <?= status_translator($order->status) ?>
                </div>
              </td>
              <td><?= $order->created_at ?></td>
              <td><?= $order->shopkeeper_name ?></td>
              <td><?= convert_to_persian_numbers($order->total_items) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>


<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>