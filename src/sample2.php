<?php
$code = <<<'CODE'
struct {
    double foo;
    long bar;
    int baz;
}
CODE;

$type = FFI::type($code);
$data = FFI::new($type);
FFI::memset($data, 0, FFI::sizeof($type));

printf("foo: %f, bar: %d, baz: %d\n", $data->foo, $data->bar, $data->baz);

$data->foo = M_PI;
$data->bar = PHP_INT_MAX;
$data->baz = PHP_INT_MAX;

printf("foo: %f, bar: %d, baz: %d\n", $data->foo, $data->bar, $data->baz);
