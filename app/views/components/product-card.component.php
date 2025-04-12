<?php

use Framework\Session;

$current_time = time();
$seven_days_ago = strtotime('-7 days');

$book_added_time = strtotime($book->created_at);
?>
<div class="card bg-base-200 rounded-none">
  <?php if (isset($book->image) and !empty($book->image)) : ?>
    <figure class="h-80 border-b border-b-base-300/50">
      <img
        src="<?= load_uploaded_book_cover($book->image) ?>"
        class="max-w-1/2" />
    </figure>
  <?php else : ?>
    <div>
      <div class="h-80 flex justify-center items-center bg-neutral text-neutral-content/50 border-b border-b-base-300/50">
        بی عکس
      </div>
    </div>
  <?php endif; ?>
  <div class="card-body">
    <div
      class="card-title hover:link hover:link-secondary flex flex-col items-start gap-0">
      <div class="flex gap-2">
        <a href="" class="line-clamp-1"> <?= $book->title ?> </a>
        <?php if ($book_added_time > $seven_days_ago) : ?>
          <div class="badge badge-secondary">جدید</div>
        <?php endif ?>
      </div>
      <div class="text-sm font-extralight">
        <a href=""><?= $book->author ?></a>
        —
        <span><?= format_price($book->price) ?></span>
      </div>
    </div>
    <div class="flex flex-nowrap space-x-2 overflow-hidden">
      <?php foreach ($book->categories as $category) : ?>
        <div class="badge badge-outline badge-xs"><?= $category ?></div>
      <?php endforeach; ?>
    </div>
    <div class="<?= empty($book->categories) ? 'mt-4' : '' ?>">
      <p class="line-clamp-3 overflow-clip text-sm font-light h-15">
        <?= $book->description ?>
      </p>
    </div>
    <?php if (Session::has('user_data')) : ?>
      <form action="/cart/<?= Session::get('user_data')['user_cart_id'] ?>/add/<?= $book->shopkeeper_book_id ?>" method="post">
        <div class="card-actions justify-end">
          <div class="join grid w-full grid-cols-5">
            <button
              type="submit"
              class="btn btn-ghost btn-outline join-item col-span-3">
              افزودن به سبد خرید
            </button>
            <a href="/books/<?= $book->shopkeeper_book_id ?>" class="btn btn-primary join-item col-span-2">
              بیشتر بگو!
            </a>
          </div>
        </div>
      </form>
    <?php else : ?>
      <div class="card-actions justify-end">
        <div class="join grid w-full grid-cols-5">
          <button
            type="submit"
            class="btn btn-ghost btn-outline join-item col-span-3 text-xs" disabled>
            برای خرید، اول وارد شوید!
          </button>
          <a href="/books/<?= $book->shopkeeper_book_id ?>" class="btn btn-primary join-item col-span-2">
            بیشتر بگو!
          </a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>