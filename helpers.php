<?php

function d(mixed $anything): void
{
  echo "<pre dir='ltr' class='font-mono'>";
  var_dump($anything);
  echo "</pre>";
}


function base_path(string $path = ""): string
{
  return __DIR__ . "/" . $path;
}

function load_view(string $view_name, array $data = []): void
{
  $view_path = base_path("app/views/{$view_name}.view.php");

  if (file_exists($view_path)) {
    extract($data);
    require($view_path);
  } else {
    echo "View <i>{$view_name}</i> doesn't exist!";
  }
}

function load_component(string $component_name, array $data = []): void
{
  $component_path = base_path("app/views/components/{$component_name}.component.php");

  if (file_exists($component_path)) {
    extract($data);
    require($component_path);
  } else {
    echo "Component <i>{$component_name}</i> doesn't exist!";
  }
}

function load_panel_view(string $panel_view_name, array $data = []): void
{
  $panel_view_path = base_path("app/views/panel/{$panel_view_name}.panel.view.php");

  if (file_exists($panel_view_path)) {
    extract($data);
    require($panel_view_path);
  } else {
    echo "Panel view <i>{$panel_view_name}</i> doesn't exist!";
  }
}

function load_partial(string $partial_name, array $data = []): void
{
  $partial_path = base_path("app/views/partials/{$partial_name}.php");

  if (file_exists($partial_path)) {
    extract($data);
    require($partial_path);
  } else {
    echo "Partial <i>{$partial_name}</i> doesn't exist!";
  }
}

function load_icon(string $icon_name): string
{
  $icon_path = "/assets/icons/{$icon_name}.svg";

  return $icon_path;
}

function load_style(string $stylesheet_name): string
{
  $stylesheet_path = "/assets/css/{$stylesheet_name}.css";

  return $stylesheet_path;
}

function load_assets(string $asset_filename): string
{
  $asset_path = "/assets/{$asset_filename}";

  return $asset_path;
}

function load_book_cover(string $book_filename): string
{
  $book_cover_path = "/assets/images/books/{$book_filename}";

  return $book_cover_path;
}

function load_uploaded_book_cover(string $book_filename): string
{
  $book_cover_path = "/uploads/book-covers/{$book_filename}";

  return $book_cover_path;
}

function redirect(string $url): void
{
  header("Location: {$url}");
  exit;
}

function convert_to_persian_numbers(string $text): string
{
  $english_numbers = range(0, 9);
  $persian_numbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

  $text_in_persian_number = str_replace($english_numbers, $persian_numbers, $text);
  return $text_in_persian_number;
}

function format_price(string $price): string
{
  $formatted_number = number_format(floatval($price));
  $persian_formatted_number = convert_to_persian_numbers($formatted_number);
  $persian_formatted_number = str_replace(',', '٬', $persian_formatted_number);
  return $persian_formatted_number . " تومان";
}

function role_translator(string $role): string
{
  $translated_version = "";
  switch ($role) {
    case "user":
      $translated_version = 'کاربر عادی';
      break;
    case "shopkeeper":
      $translated_version = 'فروشنده';
      break;
    case "admin":
      $translated_version = 'ادمین';
      break;
    case "owner":
      $translated_version = 'خدای سایت';
      break;
  }

  return $translated_version;
}

function status_translator(string $status): string
{
  $translated_version = "";
  switch ($status) {
    case "shipped":
      $translated_version = 'در راه رسیدن';
      break;
    case "pending":
      $translated_version = 'در حال تایید';
      break;
    case "delivered":
      $translated_version = 'انجام شد';
      break;
    case "canceled":
      $translated_version = 'کنسل شد';
      break;
    case "approved":
      $translated_version = 'قبول شد';
      break;
    case "rejected":
      $translated_version = 'رد شد';
      break;
    case "stopped":
      $translated_version = 'متوقف شد';
      break;
  }

  return $translated_version;
}

function join_categories(array $cats): string
{
  return implode("، ", $cats);
}
