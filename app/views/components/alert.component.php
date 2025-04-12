<?php

use Framework\Session;
?>

<?php $success_message = Session::get_flash_message('success'); ?>
<?php if ($success_message !== null) : ?>
  <div role="alert" class="alert alert-success mb-4">
    <img src="<?= load_icon('check-success') ?>">
    <span><?= $success_message ?></span>
  </div>
<?php endif; ?>

<?php $error_message = Session::get_flash_message('error'); ?>
<?php if ($error_message !== null) : ?>
  <div role="alert" class="alert alert-error mb-4">
    <img src="<?= load_icon('x') ?>" />
    <span><?= $error_message ?></span>
  </div>
<?php endif; ?>