<!doctype html>
<html
  lang="fa"
  dir="rtl"
  data-theme="Bookmook"
  class="bg-base-100 selection:bg-secondary selection:text-secondary-content font-sans text-base">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    <?php if (isset($page_title)) : ?>
      بوک‌موک | <?= $page_title ?>
    <?php else : ?>
      بوک‌موک | ما کلید دار قفسه‌های کتابخانهٔ شما هستیم
    <?php endif; ?>
  </title>
  <link rel="stylesheet" href="<?= load_style("style") ?>" />
  <link
    rel="shortcut icon"
    href="<?= load_icon("favicon") ?>"
    type="image/x-icon" />
</head>

<body class="<?= $body_styles ?? '' ?>">