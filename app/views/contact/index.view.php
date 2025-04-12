<?php load_partial('top-layout', ['page_title' => 'تماس با ما']) ?>
<?php load_partial('header') ?>

<!-- main -->
<main class="space-y-36 px-20 py-8">
  <?= load_component('alert') ?>
  <form action="/contact/message" method="post">
    <section class="px-52">
      <div class="flex flex-col gap-2 text-center">
        <h1 class="text-4xl font-extrabold">تماس با ما</h1>
        <p class="text-xl">
          شما می‌توانید از طریق این فرم با ما در تماس باشید، ما در اسرع وقت
          جواب را به ایمیل شما ارسال خواهیم کرد!
        </p>
      </div>
      <div class="mt-4">
        <div class="grid grid-cols-2 gap-4">
          <label class="floating-label">
            <span>نام و نام خانوادگی</span>
            <input
              type="text"
              placeholder="نام و نام خانوادگی"
              name="fullname"
              id="fullname"
              class="input input-lg w-full" />
          </label>
          <label class="floating-label">
            <span>ایمیل</span>
            <input
              type="text"
              placeholder="ایمیل"
              name="email"
              id="email"
              class="input input-lg w-full" />
          </label>
        </div>
        <div class="mt-4">
          <textarea
            class="textarea textarea-lg h-82 w-full resize-none"
            name="message"
            id="message"
            placeholder="پیام خود را بنویسید">
              یک چیزی
            </textarea>
        </div>
        <div class="mt-4 flex items-center justify-center">
          <button class="btn btn-primary btn-wide">ارسال پیام</button>
        </div>
      </div>
      <div class="grid grid-cols-3 gap-12 mt-10">
        <div class="flex gap-2">
          <div>
            <div class="bg-accent flex size-12 items-center justify-center">
              <img
                src="<?= load_icon('telephone-call-accent-content') ?>"
                alt="" />
            </div>
          </div>
          <div class="flex flex-col">
            <span class="font-bold">تلفن</span>
            <span class="text-sm font-light"><?= $contact_info->contact_number ?></span>
          </div>
        </div>
        <div class="flex gap-2">
          <div>
            <div class="bg-accent flex size-12 items-center justify-center">
              <img
                src="<?= load_icon('chat-messages') ?>"
                alt="" />
            </div>
          </div>
          <div class="flex flex-col">
            <span class="font-bold">ایمیل</span>
            <span class="text-sm font-light"><?= $contact_info->site_email ?></span>
          </div>
        </div>
        <div class="flex gap-2">
          <div>
            <div class="bg-accent flex size-12 items-center justify-center">
              <img
                src="<?= load_icon('map-accent-content') ?>"
                alt="" />
            </div>
          </div>
          <div class="flex flex-col">
            <span class="font-bold">آدرس</span>
            <span class="text-sm font-light"><?= $contact_info->address ?></span>
          </div>
        </div>
      </div>
    </section>
  </form>
</main>

<?php load_partial('footer') ?>
<?php load_partial('bottom-layout') ?>