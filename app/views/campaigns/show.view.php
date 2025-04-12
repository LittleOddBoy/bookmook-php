<?= load_partial('top-layout', ['page_title' => 'جستجو', 'body_styles' => 'h-dvh flex justify-between flex-col']) ?>
<div>
  <?= load_partial('header') ?>

  <main class="space-y-36 px-20 py-8">
    <section class="w-full">
      <form action="/search/books" method="get">
        <div>
          <div class="flex flex-col gap-2 text-center">
            <h1 class="text-4xl font-extrabold"><?= $c->name ?></h1>
            <p class="text-xl">
              <?= $c->description ?>
            </p>
          </div>
      </form>
</div>
<div class="mt-4">
  <div class="grid grid-cols-4 gap-4">
    <?php foreach ($c->campaign_books as $book) : ?>
      <?php $book = (object) $book; ?>
      <?= load_component('product-card', ['book' => $book]) ?>
    <?php endforeach; ?>
  </div>
</div>
</section>
</main>
</div>

<?= load_partial('footer') ?>
<?= load_partial('bottom-layout') ?>