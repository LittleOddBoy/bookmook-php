<!-- footer -->
<footer class="bg-primary text-primary-content space-y-3 px-20 py-8 order-last">
  <!-- top footer -->
  <section class="flex flex-col items-center space-y-2 justify-between">
    <div>
      <img
        src="<?= load_assets('images/transparent/logo-retro-text.png') ?>"
        class="w-20" />
    </div>
    <div>
      <ul class="flex space-x-6">
        <li>
          <a href="/" class="hover:link hover:link-secondary">صفحه اصلی</a>
        </li>
        <li>
          <a href="/books" class="hover:link hover:link-secondary">کتاب‌ها</a>
        </li>
        <li>
          <a href="/contact-us" class="hover:link hover:link-secondary">تماس با ما</a>
        </li>
        <li>
          <a href="/about-us" class="hover:link hover:link-secondary">درباره ما</a>
        </li>
      </ul>
    </div>
  </section>

  <hr class="border-base-300 opacity-10" />

  <section class="flex items-center justify-center gap-x-10">
    <span>
      &copy; تمامی حقوق برای هلدینگ بوک‌موک محفوظ است —
      <script>
        document.write(
          new Intl.DateTimeFormat("fa-IR", {
            year: "numeric"
          }).format(
            new Date(),
          ),
        );
      </script>
    </span>
</footer>