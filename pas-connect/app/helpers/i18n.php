<?php
// Simple i18n helper for PAS Connect

function get_locale(): string {
    if (!empty($_SESSION['lang'])) return $_SESSION['lang'];
    if (!empty($_COOKIE['lang'])) return $_COOKIE['lang'];
    // Default to Bahasa Melayu as requested by the user
    return 'ms';
}

function set_locale(string $lang){
    $lang = in_array($lang, ['en','ms']) ? $lang : 'en';
    $_SESSION['lang'] = $lang;
    setcookie('lang', $lang, time() + 60*60*24*30, '/');
}

function t(string $key){
    static $strings = null;
    if ($strings === null){
        $locale = get_locale();
        $file = __DIR__ . '/../lang/' . $locale . '.php';
        if (file_exists($file)){
            $strings = include $file;
        } else {
            $strings = [];
        }
    }
    return $strings[$key] ?? $key;
}
