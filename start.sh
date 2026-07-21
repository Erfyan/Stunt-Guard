#!/usr/bin/env bash
# Fix voku/portable-ascii nullable type before the app starts
php -r "
    $file = __DIR__.'/vendor/voku/portable-ascii/src/voku/helper/ASCII.php';
    if (file_exists($file)) {
        $contents = file_get_contents($file);
        $fixed = preg_replace('/bool \$(replace_single_chars_only) = null/', '?bool $1 = null', $contents);
        if ($fixed !== null) {
            file_put_contents($file, $fixed);
            echo "voku ASCII signature fixed.\n";
        }
    }
";
# Start Laravel development server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
