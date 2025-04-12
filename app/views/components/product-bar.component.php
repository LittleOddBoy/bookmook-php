<?php
$books = array_slice($c->campaign_books, 0, 4);
$books = (object) $books;
?>
<section class="w-full space-y-4">
  <div class="flex w-full justify-between">
    <div class="space-y-2">
      <h4 class="text-3xl font-extrabold">
        <?= $c->name ?>
      </h4>
      <p><?= $c->description ?></p>
    </div>
    <div>
      <a href="/campaigns/<?= $c->campaign_id ?>" class="btn btn-accent btn-outline btn-lg group">
        <span>کتاب‌های بیشتر</span>
        <img
          src="<?= load_icon('arrow-long-left-secondary-content') ?>"
          class="hidden group-hover:block" />
        <img
          src="<?= load_icon('arrow-long-left') ?>"
          class="group-hover:hidden" />
      </a>
    </div>
  </div>
  <div class="grid grid-cols-4 grid-rows-1 gap-x-4">
    <?php foreach ($books as $book) : ?>
      <?php $book = (object) $book; ?>
      <?php load_component('product-card', ['book' => $book]) ?>
    <?php endforeach; ?>
  </div>
</section>