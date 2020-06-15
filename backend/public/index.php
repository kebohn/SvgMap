<?php
if (php_sapi_name() == 'cli-server') {
    /* route static assets and return false */
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) return false;
}
(require_once __DIR__ . '/../config/bootstrap.php')->run();

