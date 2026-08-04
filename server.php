<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
//
// This application keeps its front controller in the project root (the layout
// the shared host expects), while static files still live under public/. The
// built-in server's document root is the project root, so assets have to be
// streamed from public/ by hand instead of deferring with "return false".
if ($uri !== '/' && is_file(__DIR__.'/public'.$uri)) {
    $asset = __DIR__.'/public'.$uri;

    $types = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'svg' => 'image/svg+xml',
        'json' => 'application/json',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
    ];

    $extension = strtolower(pathinfo($asset, PATHINFO_EXTENSION));

    header('Content-Type: '.($types[$extension] ?? (mime_content_type($asset) ?: 'application/octet-stream')));
    header('Content-Length: '.filesize($asset));

    readfile($asset);

    return true;
}

require_once __DIR__.'/index.php';
