<?php load_partial('top-layout', ['page_title' => 'کتاب‌ها', 'body_styles' => "h-dvh flex justify-between flex-col"]) ?>
<div>
  <?php load_partial('header') ?>
  <!-- main -->
  <main class="space-y-36 px-20 py-8">

    <!-- all products section -->
    <section class="w-full">
      <?php load_component('alert') ?>
      <div>
        <div class="flex flex-col gap-2 text-center">
          <h1 class="text-4xl font-extrabold">محصولات</h1>
          <p class="text-xl">
            گاهی انقدر محصولات خوبی داریم که خودمان هم باورمان نمی‌شود! وای به
            حال شما، مشتری عزیز
          </p>
        </div>
        <div class="mt-20">
          <?= load_component('filter-bar', ['action_url' => '/books', 'entity_count' => count($all_books), 'filter_options' => $categories]) ?>
        </div>
      </div>
      <div>
        <div class="w-full grid grid-cols-4 gap-4 mt-4">
          <?php foreach ($all_books as $book) : ?>
            <?= load_component('product-card', ['book' => $book]) ?>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  </main>
</div>



<?php load_partial('footer') ?>
<?php load_partial('bottom-layout') ?>