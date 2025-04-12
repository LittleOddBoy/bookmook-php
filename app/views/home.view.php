<?php load_partial('top-layout') ?>
<?php load_partial('header') ?>

<!-- main -->
<main class="space-y-36 px-20 py-8">
  <!-- hero section -->
  <section>
    <div
      class="bg-base-300 text-base-content
           mx-20 flex flex-col justify-between space-y-32 px-12 py-10">
      <div class="w-3/4">
        <h1 class="flex space-x-2 text-4xl leading-12 font-black">
          <img
            src="<?= load_assets('images/transparent/logo-content.svg') ?>"
            class="w-12"
            alt="" />
          <span> سایت فروشگاهی «بوک‌موک»—کلیددار کتابخانهٔ شما! </span>
        </h1>
        <p class="mt-4">
          لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
          استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله
          در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد
          نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد،
          کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان
          جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای
          طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان
          فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری
          موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد
          نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل
          دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
        </p>
      </div>
      <div class="flex flex-col items-end">
        <a href="" class="btn btn-accent btn-outline group">
          <span class="font-bold"> بیشتر راجب این پروژه بدانید </span>
          <img
            src="<?= load_icon('arrow-up-right-accent') ?>"
            class="-scale-x-100 group-hover:hidden" />
          <img
            src="<?= load_icon('arrow-up-right-accent-content') ?>"
            class="hidden -scale-x-100 -rotate-45 group-hover:block" />
        </a>
      </div>
    </div>
  </section>

  <!-- abilities section -->
  <section class="flex justify-between">
    <div>
      <div class="sticky top-32 flex w-8/12 flex-col space-y-4">
        <div>
          <img src="<?= load_icon('like') ?>" class="size-20" />
        </div>
        <h3 class="text-4xl font-extrabold">ویژگی‌های ما</h3>
        <p class="text-2xl">
          ما تمام سعی خود را می‌کنیم تا بهترین خدمات را به مشتریان ارائه
          بدهیم.
        </p>
        <div>
          <a href="/about-us" class="btn btn-primary btn-outline"> بیشتر بدانید </a>
        </div>
      </div>
    </div>

    <div class="grid w-1/2 grid-cols-2 grid-rows-2 gap-14">
      <div class="flex flex-col space-y-2 text-justify">
        <div
          class="bg-base-300 flex size-20 shrink-0 items-center justify-center">
          <img src="<?= load_icon('percentage') ?>" class="size-12" />
        </div>
        <h4
          class="decoration-secondary text-2xl font-bold underline decoration-wavy">
          مناسب‌ترین قیمت‌ها
        </h4>
        <p class="font-light">
          هیچ‌گاه مناسب‌ترین قیمت به معنی ارزان‌ترین قیمت نیست. در فروشگاه
          ما مناسب‌ترین قیمت به معنی این است که بیشترین بهره‌وری با کمترین
          قیمت اجرا شود.
        </p>
      </div>
      <div class="flex flex-col space-y-2 text-justify">
        <div
          class="bg-base-300 flex size-20 shrink-0 items-center justify-center">
          <img src="<?= load_icon('telephone-call') ?>" class="size-12" />
        </div>
        <h4
          class="decoration-secondary text-2xl font-bold underline decoration-wavy">
          پشتیبانی از شما
        </h4>
        <p class="font-light">
          تیم پشتیبان ما در تمام ساعات پشتیبان شما هستند، اگر به مشکلی
          برخوردید کافیست با تیم ما تماس بگیرید تا در سریع‌ترین زمان ممکن
          مشکل شما را حل کنند.
        </p>
      </div>
      <div class="flex flex-col space-y-2 text-justify">
        <div
          class="bg-base-300 flex size-20 shrink-0 items-center justify-center">
          <img src="<?= load_icon('earth') ?>" class="size-12" />
        </div>
        <h4
          class="decoration-secondary text-2xl font-bold underline decoration-wavy">
          کتاب‌های روز
        </h4>
        <p class="font-light">
          ما همیشه سعی می‌کنیم به روزترین کتاب‌های حال حاضر جهان را در
          فروشگاه خود ارائه دهیم تا به بهترین کیفیت جهان دسترسی داشته باشید.
        </p>
      </div>
      <div class="flex flex-col space-y-2 text-justify">
        <div
          class="bg-base-300 flex size-20 shrink-0 items-center justify-center">
          <img src="<?= load_icon('chart-pie-two') ?>" class="size-12" />
        </div>
        <h4
          class="decoration-secondary text-2xl font-bold underline decoration-wavy">
          آنالیز دقیق داده
        </h4>
        <p class="font-light">
          ما به دقیق‌ترین شکل ممکن و با استفاده از هوش‌مصنوعی نیازهای
          کاربران خود را آنالیز کرده و پیشنهاد‌های خود را بر اساس علایق آنان
          تنظیم می‌کنیم.
        </p>
      </div>
    </div>
  </section>

  <!-- products section -->
  <section class="flex justify-between">
    <div class="grid w-1/2 grid-cols-2 grid-rows-2 gap-8">
      <?php foreach ($most_recent_books as $book) : ?>
        <?php load_component('product-card', ['book' => $book])
        ?>
      <?php endforeach; ?>
    </div>

    <div>
      <div class="sticky top-32 flex flex-col space-y-4 text-left">
        <div class="sticky flex justify-end">
          <img src="<?= load_icon('cart') ?>" class="size-20" />
        </div>
        <h3 class="text-4xl font-extrabold">جدیدترین کتاب‌های ما</h3>
        <p class="text-2xl">
          کتاب‌هایی که همین اواخر به جمع‌مان اضافه شدند!
        </p>
        <div>
          <a href="/books" class="btn btn-primary btn-outline">دیدن همهٔ کتاب‌ها</a>
        </div>
      </div>
    </div>
  </section>

  <!-- request for book section -->
  <section
    class="bg-primary text-primary-content flex items-center justify-between px-20 py-24">
    <div class="w-1/2 space-y-4">
      <h3 class="text-4xl font-extrabold">
        محصول مورد نظرتان را پیدا نکردید؟!
      </h3>
      <p class="text-2xl">
        نام کتاب موردنظر را برایمان بنویسید تا در اسرع وقت آن را برایتان
        پیدا کنیم!
      </p>
    </div>
    <div class="w-1/2 space-y-2">
      <!-- TODO: do this -->
      <label class="label text-2xl"> اینجا بنویسید: </label>
      <div class="grid grid-cols-4">
        <input
          type="text"
          class="input input-neutral input-xl text-neutral-content col-span-3 w-full" />
        <button class="btn btn-secondary btn-xl">ارسال</button>
      </div>
    </div>
  </section>

  <!-- product bar section 1 -->
  <section class="w-full space-y-4">
    <?php foreach ($campaigns as $c) : ?>
      <?= load_component('product-bar', ['c' => $c]) ?>
    <?php endforeach; ?>
  </section>

</main>

<?php load_partial('footer') ?>
<?php load_partial('bottom-layout') ?>