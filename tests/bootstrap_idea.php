<?php
$env = Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();
putenv('LIBMECAB_PATH=' . $env['LIBMECAB_PATH']);
if (isset($env['MECAB_IPADIC_UTF8_DIR'])) {
    putenv('MECAB_IPADIC_UTF8_DIR=' . $env['MECAB_IPADIC_UTF8_DIR']);
}
