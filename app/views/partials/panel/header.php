<?php

use Framework\Session; ?>
<header class="min-w-full bg-base-200 text-base-content border-b border-base-300/70 flex justify-between items-center px-4 py-[15px]">
  <div>
    <span>
      <script>
        const date = new Date();
        const formatter = new Intl.DateTimeFormat('fa-IR', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric',
        });

        const formattedDate = formatter.format(date);

        console.log(formattedDate)
        const parts = formattedDate.split(' ');

        const reorderedDate = `${parts[parts.length - 1]}، ${parts[parts.length - 2].slice(0, parts[parts.length - 2].length - 1)} ${parts[1]} ${parts[0]}`;

        document.write(reorderedDate);
      </script>
    </span>
    <span>—</span>
    <span>
      <script>
        const now = new Date();
        const hours = now.getHours();

        let greeting = "";

        if (hours >= 5 && hours < 10) {
          greeting = "صبح بخیر";
        } else if (hours >= 10 && hours < 14) {
          greeting = "ظهر بخیر";
        } else if (hours >= 14 && hours < 18) {
          greeting = "عصر بخیر";
        } else {
          greeting = "شب خوش";
        }

        document.write(greeting);
      </script>
      <?= Session::get('user_data')['fullname'] ?>
      عزیز!
    </span>
  </div>
  <div class="flex gap-2">
    <form action="/auth/logout" method="post">
      <button class="btn btn-error">
        <img src="<?= load_icon('logout') ?>">
        <span>خروج از حساب کاربری</span>
      </button>
    </form>
  </div>
</header>