<?php
$code = <<<'CODE'
typedef struct mecab_t mecab_t;
mecab_t* mecab_new2(const char *arg);
void mecab_destroy(mecab_t *mecab);
const char* mecab_sparse_tostr(mecab_t *mecab, const char *str);
CODE;

$ffi = FFI::cdef($code, '/opt/local/lib/libmecab.dylib');
$mecab = $ffi->mecab_new2('');
echo $ffi->mecab_sparse_tostr($mecab, '全ては猫様のために');
$ffi->mecab_destroy($mecab);
