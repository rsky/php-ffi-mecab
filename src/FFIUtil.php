<?php

namespace MeCab;

use FFI;
use FFI\CData;

class FFIUtil
{
    public static function toCString(string $str, bool $owned = true): CData
    {
        $length = strlen($str);
        $cString = FFI::new(sprintf('char[%d]', $length + 1), $owned);
        FFI::memcpy($cString, $str, $length);
        $cString[$length] = "\0";

        return $cString;
    }
}
