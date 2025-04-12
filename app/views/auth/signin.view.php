<?php load_partial('top-layout', ['page_title' => 'خوش آمدید!']) ?>
<?php load_partial('header') ?>
<!-- main -->
<main class="space-y-36 px-20 py-8">
  <!-- sign-in section -->
  <form action="/auth/signin" method="post">
    <section class="flex w-full items-center justify-between px-20">
      <div class="flex flex-col gap-2">
        <h1 class="text-4xl font-extrabold">
          لذت خرید را با ما تجربه کنید، <br />
          بهترین محصولات را از ما بخواهید!
        </h1>
        <p>
          بوک‌موک دارای بهترین و با کیفیت‌ترین کتاب‌های فیزیکی در خاورمیانه
          است و همیشه متنوع با سلیقهٔ شماست. <br />
          شک دارید؟ ثبت‌نام کنید و خرید کنید تا مطمئن شوید!
        </p>
      </div>
      <div class="flex flex-col gap-2">
        <h4 class="font-bold">خوش آمدید</h4>
        <div class="flex flex-col gap-4 w-72">
          <div>
            <label class="floating-label">
              <span>نام و نام خانوادگی</span>
              <input
                type="text"
                placeholder="نام و نام خانوادگی"
                name="fullname"
                id="fullname"
                class="input input-lg" />
            </label>
            <?php if (isset($errors['fullname']) and !empty($errors['fullname'])) : ?>
              <div role="alert" class="alert alert-error alert-soft mt-1">
                <span><?= $errors['fullname'] ?></span>
              </div>
            <?php endif; ?>
          </div>
          <div>
            <label class="floating-label">
              <span>ایمیل</span>
              <input type="email" placeholder="ایمیل" name='email' id='email' class="input input-lg" />
            </label>
            <?php if (isset($errors['email']) and !empty($errors['email'])) : ?>
              <div role="alert" class="alert alert-error alert-soft mt-1">
                <span><?= $errors['email'] ?></span>
              </div>
            <?php endif; ?>
            <?php if (isset($errors['email_already_exists']) and !empty($errors['email_already_exists'])) : ?>
              <a href='/auth/login' role="alert" class="alert alert-warning alert-soft mt-1 hover:border-amber-700">
                <span><?= $errors['email_already_exists'] ?></span>
              </a>
            <?php endif; ?>
          </div>
          <div>
            <label class="floating-label">
              <span>گذرواژه</span>
              <input
                type="password"
                placeholder="گذرواژه"
                name='password'
                id='password'
                class="input input-lg" />
            </label>
            <?php if (isset($errors['password']) and !empty($errors['password'])) : ?>
              <div role="alert" class="alert alert-error alert-soft mt-1">
                <span><?= $errors['password'] ?></span>
              </div>
            <?php endif; ?>
          </div>
          <div>
            <label class="floating-label">
              <span>تکرار گذرواژه</span>
              <input
                type="password"
                placeholder="تکرار گذرواژه"
                name='password_confirm'
                id='password_confirm'
                class="input input-lg" />
            </label>
            <?php if (isset($errors['password_confirm']) and !empty($errors['password_confirm'])): ?>
              <div role="alert" class="alert alert-error alert-soft mt-1">
                <span><?= $errors['password_confirm'] ?></span>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div>
          <p>
            قبلاً ثبت‌نام کردید؟
            <a href="/auth/login" class="link link-secondary">وارد شوید</a>
          </p>
        </div>
        <div class="flex flex-col gap-2 mt-2">
          <button type="submit" class="btn btn-primary btn-lg">ثبت نام</button>

          <button
            class="group btn btn-secondary btn-outline btn-lg"
            onclick="scam()">
            <img
              src="<?= load_icon('brand-google') ?>"
              class="group-hover:hidden" />
            <img
              src="<?= load_icon('brand-google-secondary-content') ?>"
              class="hidden group-hover:block" />
            <span>ورود با گوگل</span>
          </button>
        </div>
      </div>
    </section>
  </form>
</main>

<?= load_partial('footer') ?>
<script>
  function scam() {
    alert(
      "شاید اگر به اینترنت دسترسی داشتیم، فکری برای این فیچر می‌کردیم:)))))",
    );
  }
</script>

<?php load_partial('bottom-layout') ?>