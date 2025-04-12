<?=
load_partial('top-layout', [
  'page_title' => 'پنل | کتاب‌های شما | ویرایش',
]);
?>

<?php

use Framework\Session;

load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>
<?php

$request_endpoint =
  in_array(Session::get('user_data')['role'], ['admin', 'owner'])
  ? "/book/{$book->book_id}/update"
  : "/book/{$book->shopkeeper_book_id}/update_mini";

?>

<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <?php load_component('alert') ?>
    <div class="flex gap-4">
      <h1 class="font-extrabold text-4xl">
        ویرایش کتاب: <?= $book->title ?>
      </h1>
    </div>
    <section class="mt-4">
      <form action="<?= $request_endpoint ?>" method="post">
        <div class="w-lg grid grid-cols-2 gap-y-2 items-start">
          <?php if (in_array(Session::get('user_data')['role'], ['admin', 'owner'])) : ?>
            <label for="title" class="label">
              نام کتاب
            </label>
            <input
              type="text"
              name="title"
              id="title"
              class="input input-secondary"
              value="<?= $book->title ?>">
            <?php if (isset($errors['title']) and !empty($errors['title'])) : ?>
              <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
                <span><?= $errors['title'] ?></span>
              </div>
            <?php endif; ?>

            <label for="author" class="label">
              نویسنده
            </label>
            <input type="text" name="author" id="author" class="input input-secondary" value="<?= $book->author ?>">
            <?php if (isset($errors['author']) and !empty($errors['author'])) : ?>
              <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
                <span><?= $errors['author'] ?></span>
              </div>
            <?php endif; ?>

            <label for="description" class="label">
              توضیحات
            </label>
            <textarea
              class="textarea textarea-lg h-82 w-full"
              name="description"
              id="description"
              placeholder="توضیحاتی راجب کتاب بنویسید..."><?= $book->description ?></textarea>

            <!-- TODO: may be it's better to show a red text rather than an alert??? -->
            <?php if (isset($errors['description']) and !empty($errors['description'])) : ?>
              <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
                <span><?= $errors['description'] ?></span>
              </div>
            <?php endif; ?>

            <label for="categories" class="label">دسته‌بندی‌ها</label>
            <input type="text" name="categories" id="categories" class="input input-secondary" value="<?= $book->categories ?>">
            <?php if (isset($errors['categories']) and !empty($errors['categories'])) : ?>
              <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
                <span><?= $errors['categories'] ?></span>
              </div>
            <?php endif; ?>

            <label for="isbn" class="label">شابک (ISBN)</label>
            <input type="text" name="isbn" id="isbn" class="input input-secondary" value="<?= $book->isbn ?>">
            <?php if (isset($errors['isbn']) and !empty($errors['isbn'])) : ?>
              <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
                <span><?= $errors['isbn'] ?></span>
              </div>
            <?php endif; ?>

            <label for="published_at" class="label">تاریخ انتشار کتاب</label>
            <input type="date" name="published_at" id="published_at" class="input input-secondary" value="<?= $book->published_at ?>">
            <?php if (isset($errors['published_at']) and !empty($errors['published_at'])) : ?>
              <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
                <span><?= $errors['published_at'] ?></span>
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <label for="price" class="label">قمیت</label>
          <input type="number" name="price" id="price" class="input input-secondary" value="<?= floatval($book->price) ?>">
          <?php if (isset($errors['price']) and !empty($errors['price'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['price'] ?></span>
            </div>
          <?php endif; ?>

          <label for="stock" class="label">موجودی</label>
          <input type="number" name="stock" id="stock" class="input input-secondary" value="<?= $book->stock ?>">
          <?php if (isset($errors['stock']) and !empty($errors['stock'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['stock'] ?></span>
            </div>
          <?php endif; ?>
        </div>
        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <img src="<?= load_icon('check-success') ?>">
            <span>
              به روز رسانی
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