<?php

use Framework\Session; ?>
<?= load_partial('top-layout', ['page_title' => 'سبد خرید', 'body_styles' => "h-dvh flex justify-between flex-col"]) ?>
<div>
  <?= load_partial('header') ?>

  <main class="space-y-36 px-20 py-8">
    <section class="w-full mx-auto flex justify-center">
      <div class="w-1/2 space-y-4">
        <div class="text-center">
          <h1 class="font-extrabold text-4xl">
            سبد خرید
          </h1>
        </div>
        <div class="py-4 border-y-2 border-base-300/50 divide-y divide-dashed divide-base-300/90">
          <?php foreach ($cart_items as $c) : ?>
            <div class="flex justify-between py-6 h-52">
              <div class="flex">
                <?php if (isset($c->image) and !empty($c->image)) : ?>
                  <div class="me-4 overflow-hidden">
                    <img class="h-full w-28 border border-base-300/50" src="<?= load_uploaded_book_cover($c->image) ?>">
                  </div>
                <?php else : ?>
                  <div class="me-4 overflow-hidden">
                    <div class="h-full w-28 bg-neutral text-neutral-content/50 border border-base-300/50 flex justify-center items-center text-xs select-none">
                      بی‌عکس
                    </div>
                  </div>
                <?php endif; ?>
                <div class="flex flex-col justify-between">
                  <div>
                    <span class="font-bold"><?= $c->title ?></span> <br>
                    <span class="font-light"><?= $c->author ?></span>
                  </div>
                  <div>
                    <span><?= $c->shopkeeper_name ?></span>
                    <div class="badge badge-outline badge-sm badge-accent">فروشنده</div>
                  </div>
                </div>
              </div>
              <div class="flex flex-col items-end justify-between">
                <div class="text-left">
                  <div>
                    <span>
                      <?= format_price($c->price) ?>
                    </span>
                    <div class="badge badge-secondary badge-sm">هر جلد</div>
                  </div>
                  <div class="mt-2">
                    <form
                      action="/cart/<?= Session::get('user_data')['user_cart_id'] ?>/quantity/<?= $c->cart_item_id ?>"
                      method="post"
                      id="quantity-<?= $c->cart_item_id ?>"
                      name="quantity-<?= $c->cart_item_id ?>">
                      <select
                        name="quantity"
                        id="quantity"
                        onchange='changeQuantity("<?= $c->cart_item_id ?>")'
                        class="select select-sm">
                        <?php for ($i = 1; $i <= $c->stock; $i++) : ?>
                          <option <?= (int) $c->quantity == $i ? 'selected' : '' ?> value="<?= $i ?>"><?= convert_to_persian_numbers($i) ?> جلد</option>
                        <?php endfor; ?>
                      </select>
                    </form>
                  </div>
                </div>
                <div>
                  <form
                    action="/cart/<?= Session::get('user_data')['user_cart_id'] ?>/remove/<?= $c->cart_item_id ?>"
                    method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-error btn-sm">
                      <img src="<?= load_icon('x') ?>" class="size-5">
                      <span class="mt-1">حذف</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div>
          <form action="/cart/<?= Session::get('user_data')['user_cart_id'] ?>/make-empty" name="emptyForm" id="emptyForm" method="post">
            <input type="hidden" name="_method" value="DELETE">
          </form>
          <form action="/cart/<?= Session::get('user_data')['user_cart_id'] ?>/calculate" name="calculateForm" id="calculateForm" method="post"></form>
          <div class="w-full grid grid-cols-12 grid-rows-1 join">
            <button class="btn btn-primary col-span-8 join-item" onclick="calculateAreYouSure()">
              <img src="<?= load_icon('chevron-right') ?>">
              <span>
                مشاهده فاکتور و نهایی سازی خرید
              </span>
            </button>
            <button class="group btn btn-error col-span-4 btn-outline join-item" onclick="clearAllAreYouSure()">
              <img src="<?= load_icon('trash-error') ?>" class="group-hover:hidden">
              <img src="<?= load_icon('trash') ?>" class="hidden group-hover:block">
              <span> خالی کردن سبد خرید</span>
            </button>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>

<script>
  function changeQuantity(itemId) {
    let targetFormName = `quantity-${itemId}`;
    let targetForm = document.getElementById(targetFormName);

    targetForm.submit();
  }

  function clearAllAreYouSure() {
    const targetForm = document.getElementById('emptyForm');
    const ans = confirm('از عمل خود مطمئن هستید؟ سبد خرید شما به طور کامل خالی خواهد شد!');

    if (ans) {
      targetForm.submit();
    }
  }

  function calculateAreYouSure() {
    const targetForm = document.getElementById('calculateForm');
    const ans = confirm('مطمئنید که نمی‌خواهید بیشتر خرید کنید؟');

    if (ans) {
      targetForm.submit();
    }
  }
</script>

<?= load_partial('footer') ?>
<?= load_partial('bottom-layout') ?>