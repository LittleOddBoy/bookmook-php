<?=
load_partial('top-layout', [
  'page_title' => 'پنل | مدیریت کاربران',
]);
?>

<?php

use Framework\Session;

load_partial('panel/top-layout') ?>
<?php load_partial('panel/sidebar') ?>


<main class="p-4 w-full min-h-svh">
  <?php load_partial('panel/header') ?>
  <div class="w-[calc(100svw-300px)] h-[calc(100svh-100px)] bg-base-100 text-base-content overflow-y-auto p-3">
    <?php load_component('alert') ?>
    <div class="flex gap-4">
      <h1 class="font-extrabold text-4xl">
        لیست کاربران
      </h1>
      <!-- TODO: we need a icon -->
      <a href="/panel/users/create" class="btn btn-primary">
        <img src="<?= load_icon('plus') ?>">
        <span>
          کاربر جدید
        </span>
      </a>
    </div>
    <div class="mt-4">
      <table class="table table-zebra">
        <!-- head -->
        <thead>
          <tr>
            <th></th>
            <th>کد کاربر</th>
            <th>نام کامل</th>
            <th>ایمیل</th>
            <th>نقش</th>
            <th>تاریخ ثبت‌نام</th>
            <th>آخرین آپدیت</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user) : ?>
            <?php
            $isMe = Session::get('user_data')['user_id'] == $user->user_id;
            ?>
            <tr>
              <td class="text-nowrap">
                <?php if (!in_array($user->user_role, ['admin', 'owner'])) : ?>
                  <form action="/user/<?= $user->user_id ?>/to-admin" method="post" class="hidden" id="toAdminForm<?= $user->user_id ?>"></form>

                  <!-- TODO: we need a icon for this button -->
                  <div class="tooltip tooltip-primary" data-tip="ارتقا به ادمین">
                    <button class="btn btn-primary btn-sm btn-square" onclick="document.getElementById('toAdminForm<?= $user->user_id ?>').submit()">
                      <img src="<?= load_icon('chevron-double-up') ?>">
                    </button>
                  </div>
                <?php endif; ?>
                <?php if (in_array($user->user_role, ['admin'])) : ?>
                  <form action="/user/<?= $user->user_id ?>/to-user" method="post" class="hidden" id="toUserForm<?= $user->user_id ?>"></form>

                  <!-- TODO: we need a icon for this button -->
                  <div class="tooltip tooltip-secondary" data-tip="نزول به کاربر عادی">
                    <button class="btn btn-secondary btn-sm btn-square" onclick="document.getElementById('toUserForm<?= $user->user_id ?>').submit()">
                      <img src="<?= load_icon('chevron-double-down') ?>">
                    </button>
                  </div>
                <?php endif; ?>
                <?php if (in_array($user->user_role, ['user', 'shopkeeper'])) : ?>
                  <form action="/user/<?= $user->user_id ?>/delete" method="post" class="hidden" id="deleteUserForm<?= $user->user_id ?>">
                    <input type="hidden" name="_method" value="DELETE">
                  </form>

                  <!-- TODO: we need a icon for this button -->
                  <div class="tooltip tooltip-error" data-tip="حذف">
                    <button class="btn btn-error btn-sm btn-square" onclick="deleteUserConfirm(<?= $user->user_id ?>)">
                      <img src="<?= load_icon('trash') ?>">
                    </button>
                  </div>
                <?php endif; ?>
              </td>
              <td><?= convert_to_persian_numbers($user->user_id) ?></td>
              <td>
                <span class="<?= $isMe ? 'underline decoration-wavy decoration-secondary font-bold' : '' ?>">
                  <?= $user->user_fullname ?>
                </span>
              </td>
              <td><?= $user->user_email ?></td>
              <td><?= role_translator($user->user_role) ?></td>
              <td><?= $user->created_at ?></td>
              <td><?= $user->updated_at ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<script>
  function deleteUserConfirm(userId) {
    const isSure = confirm("شما در حال حذف کردن یک کاربر هستید! آیا از عمل خود اطمینان دارید؟");

    if (isSure) {
      let deletionForm = document.getElementById("deleteUserForm" + userId);
      deletionForm.submit();
    }
  }
</script>

<?php load_partial('panel/bottom-layout') ?>
<?= load_partial('bottom-layout') ?>