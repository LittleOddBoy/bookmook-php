<?php load_partial('top-layout', ['page_title' => 'خوش برگشتید!']) ?>
<?php load_partial('header') ?>

<!-- main -->
<main class="space-y-36 px-20 py-8 min-h-[450px]">
  <form action="/auth/login" method="post">

    <!-- login section -->
    <section class="flex w-full items-center justify-between px-20">
      <div class="flex flex-col gap-2">
        <h4 class="font-bold">خوش برگشتید</h4>
        <div class="flex flex-col gap-4 w-72">
          <?php if (isset($errors['user_does_not_exist']) and !empty($errors['user_does_not_exist'])) : ?>
            <div>
              <a href="/auth/signin" role="alert" class="alert alert-error alert-soft mt-1">
                <span><?= $errors['user_does_not_exist'] ?></span>
              </a>
            </div>
          <?php endif; ?>
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
            <div>
              <?php if (isset($errors['password']) and !empty($errors['password'])): ?>
                <div role="alert" class="alert alert-error alert-soft mt-1">
                  <span><?= $errors['password'] ?></span>
                </div>
              <?php endif; ?>
              <?php if (isset($errors['incorrect_password']) and !empty($errors['incorrect_password'])): ?>
                <div role="alert" class="alert alert-error alert-soft mt-1">
                  <span><?= $errors['incorrect_password'] ?></span>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div>
          <p>
            تازه وارد هستید؟
            <a href="/auth/signin" class="link link-secondary">ثبت نام کنید</a>
          </p>
        </div>
        <div class="flex flex-col gap-2">
          <button type="submit" class="btn btn-primary btn-lg">ورود</button>

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
      <div class="flex flex-col gap-2">
        <h1 class="text-4xl font-extrabold">
          راهی دوباره برای لذت بردن از زندگی، <br>
          اینبار با کتاب‌ها!
        </h1>
        <p>
          مطمئن هستیم که خاطرات خوبی از نام فروشگاه ما دارید،
          دوباره این لحظات را تجربه کنید!
        </p>
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