<?php

use Framework\Session; ?>
<?php load_partial('top-layout') ?>
<?php load_partial('header') ?>

<!-- main -->
<main class="space-y-36 px-20 py-8">
  <section>
    <div class="w-3/5 mx-auto">
      <div class="flex justify-start gap-4">
        <?php foreach ($book->categories as $category): ?>
          <div class="badge badge-outline badge-xl"><?= $category ?></div>
        <?php endforeach; ?>
      </div>
      <div class="flex justify-between mt-4">
        <div class="max-w-1/2">
          <div class="grid grid-cols-2 justify-between">
            <div>
              <h1 class="font-extrabold text-4xl">
                <?= $book->title ?>
              </h1>
            </div>
            <div class="text-left">
              <span class="font-extralight text-2xl">
                <?= format_price($book->price) ?>
              </span>
            </div>
          </div>
          <div class="mt-4">
            <div class="text-xl">
              <span class="text-slate-600/50">فروشنده: </span>
              <span class="font-bold">
                <?= $book->shopkeeper_name ?>
              </span>
            </div>
            <p>
              <?= $book->description ?>
            </p>
            <div>
              <?php if (Session::has('user_data')) : ?>
                <form action="/cart/<?= Session::get('user_data')['user_cart_id'] ?>/add/<?= $book->shopkeeper_book_id ?>" method="post">
                  <div class="card-actions justify-end">
                    <div class="grid w-full grid-cols-1">
                      <button
                        type="submit"
                        class="btn btn-ghost btn-outline col-span-3">
                        افزودن به سبد خرید
                      </button>
                    </div>
                  </div>
                </form>
              <?php else : ?>
                <div class="card-actions justify-end">
                  <div class="grid w-full grid-cols-1">
                    <button
                      type="submit"
                      class="btn btn-primary btn-outline col-span-3 text-xs" disabled>
                      برای خرید، اول وارد شوید!
                    </button>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="flex">
          <?php if (isset($book->image) and !empty($book->image)) : ?>
            <figure class="h-80">
              <img
                src="<?= load_book_cover($book->image) ?>"
                class="w-52" />
            </figure>
          <?php else : ?>
            <div>
              <div class="h-80 flex w-62 justify-center items-center bg-neutral text-neutral-content/50">
                بی عکس
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</main>

<?php load_partial('footer') ?>
<?php load_partial('bottom-layout') ?>