<?php
$code = <<<'CODE'
struct {
    long foo;
    double bar;
}
CODE;

$type = FFI::type($code);
$data = FFI::new($type);
FFI::memset($data, 0, FFI::sizeof($type));
printf("foo: %d, bar: %f\n", $data->foo, $data->bar);
$data->foo = PHP_INT_MAX;
$data->bar = M_PI;
printf("foo: %d, bar: %f\n", $data->foo, $data->bar);
