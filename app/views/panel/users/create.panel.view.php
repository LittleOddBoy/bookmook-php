<?=
load_partial('top-layout', [
  'page_title' => 'پنل | مدیریت کاربران | ساخت کاربر جدید',
]);
?>

<?php
load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>


<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <?php load_component('alert') ?>
    <div class="flex gap-4">
      <h1 class="font-extrabold text-4xl">
        ساخت کاربر جدید
      </h1>
    </div>
    <section class="mt-4">
      <form action="/user/create" method="post">
        <div class="w-lg grid grid-cols-2 gap-y-2">
          <label for="fullname" class="label">
            نام و نام خانوادگی
          </label>
          <input
            type="text"
            name="fullname"
            id="fullname"
            class="input input-secondary"
            value="<?= $old_data['fullname'] ?? '' ?>">
          <?php if (isset($errors['fullname']) and !empty($errors['fullname'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['fullname'] ?></span>
            </div>
          <?php endif; ?>

          <label for="email" class="label">
            ایمیل
          </label>
          <input type="email" name="email" id="email" class="input input-secondary" value="<?= $old_data['email'] ?? '' ?>">
          <?php if (isset($errors['email']) and !empty($errors['email'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['email'] ?></span>
            </div>
          <?php endif; ?>

          <label for="password" class="label">رمز عبور</label>
          <input type="password" name="password" id="password" class="input input-secondary">
          <?php if (isset($errors['password']) and !empty($errors['password'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['password'] ?></span>
            </div>
          <?php endif; ?>

          <label for="password_confirmation" class="label">تکرار رمز عبور</label>
          <input type="password" name="password_confirmation" id="password_confirmation" class="input input-secondary">
          <?php if (isset($errors['password_confirmation']) and !empty($errors['password_confirmation'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['password_confirmation'] ?></span>
            </div>
          <?php endif; ?>

          <label for="role" class="label">نقش کاربر</label>
          <select name="role" id="role" class="select">
            <option value="user" selected>کاربر عادی</option>
            <option value="admin" <?= $old_data['role'] == 'admin' ? 'selected' : '' ?>>ادمین</option>
            <option value="owner" <?= $old_data['role'] == 'owner' ? 'selected' : '' ?>>خدای سایت</option>
          </select>
          <?php if (isset($errors['role']) and !empty($errors['role'])) : ?>
            <div role="alert" class="alert alert-error alert-soft mt-1 col-span-2">
              <span><?= $errors['role'] ?></span>
            </div>
          <?php endif; ?>
        </div>
        <div class="mt-4">
          <button type="submit" class="btn btn-primary">
            <img src="<?= load_icon('check-success') ?>">
            <span>
              ساخت کاربر جدید
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