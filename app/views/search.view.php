<?= load_partial('top-layout', ['page_title' => 'جستجو', 'body_styles' => 'h-dvh flex justify-between flex-col']) ?>
<div>
  <?= load_partial('header') ?>

  <main class="space-y-36 px-20 py-8">
    <section class="w-full">
      <form action="/search/books" method="get">
        <div>
          <div class="flex flex-col gap-2 text-center">
            <h1 class="text-4xl font-extrabold">جستجو</h1>
            <p class="text-xl">
              دنبال کتاب خاصی می‌گردید؟ از اینجا به جستجوی آن بپردازید!
            </p>
            <div>
              <div class="join w-full flex justify-center">
                <input type="text" class="join-item input" placeholder="کلید واژه" name="search_keyword" id="search_keyword" value="<?= $_GET['search_keyword'] ?? '' ?>">
                <select name="search_category" id="search_category" class="join-item select w-40">
                  <option selected value="همه">همه</option>
                  <?php foreach ($categories as $c) : ?>
                    <option <?= isset($_GET['search_category']) && $_GET['search_category'] == $c->name ? 'selected' : '' ?> value="<?= $c->name ?>"><?= $c->name ?></option>
                  <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-accent join-item">جستجو</button>
              </div>
            </div>
          </div>
      </form>
    </section>
  </main>
</div>

<?php if (isset($results)) : ?>
  <div class="mt-4 px-20 py-8">
    <div class="grid grid-cols-4 gap-4">
      <?php foreach ($results as $book) : ?>
        <?= load_component('product-card', ['book' => $book]) ?>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>


<?= load_partial('footer') ?>
<?= load_partial('bottom-layout') ?>