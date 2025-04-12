<form action="<?= $action_url ?>" method="get" id="filterBarComp">
  <div class="flex w-full items-center justify-between">
    <?php if ($entity_count >= 1) : ?>
      <div class="flex items-center gap-1">
        <div class="bg-primary size-3"></div>
        &nbsp;
        <span class="decoration-secondary underline decoration-wavy">
          <?= convert_to_persian_numbers($entity_count) ?>
        </span>
        <span>جلد کتاب</span>
        <span class="text-accent opacity-50">بارگیری شد.</span>
      </div>
    <?php else : ?>
      <div class="flex items-center gap-1">
        <div class="bg-primary size-3"></div>
        &nbsp;
        <span class="text-accent opacity-50">کتابی یافت نشد!</span>
      </div>
    <?php endif; ?>
    <div class="flex gap-8">
      <div>
        <select
          name="category_filter"
          id="category_filter"
          class="select">
          <option selected value="همه">همه</option>
          <?php foreach ($filter_options as $fo) : ?>
            <option <?= isset($_GET['category_filter']) && $_GET['category_filter'] == $fo->name ? 'selected' : '' ?> value="<?= $fo->name ?>"><?= $fo->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="flex items-center gap-3">
        <div>
          <span
            class="text-accent decoration-secondary underline decoration-wavy opacity-50">مرتب سازی بر اساس</span>
        </div>
        <label class="label">
          <input
            type="radio"
            class="radio radio-accent"
            <?= !isset($_GET['category_order']) ? 'checked' : '' ?>
            <?= isset($_GET['category_order']) && $_GET['category_order'] == 'desc' ? 'checked' : '' ?>
            name="category_order"
            id="category_order"
            value="desc" />
          جدیدترین‌ها
        </label>
        <label class="label">
          <input
            type="radio"
            class="radio radio-accent"
            <?= isset($_GET['category_order']) && $_GET['category_order'] == 'asc' ? 'checked' : '' ?>
            name="category_order"
            id="category_order"
            value="asc" />
          قدیمی‌ترین‌ها
        </label>
      </div>
      <div>
        <button class="btn btn-primary" onclick="document.getElementById('filterBarComp').submit()">
          <span> اعمال فیلترها </span>
          <img
            src="<?= load_icon('arrow-long-left-secondary-content') ?>" />
        </button>
      </div>
    </div>
  </div>
</form>