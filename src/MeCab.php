<?php
namespace MeCab;

use FFI;
use RuntimeException;

class MeCab
{
    private const C_DEF = <<<'DEF'
typedef struct mecab_t mecab_t;

mecab_t* mecab_new(int argc, const char **argv);
mecab_t* mecab_new2(const char *arg);
const char* mecab_version();
const char* mecab_strerror(mecab_t *mecab);
void mecab_destroy(mecab_t *mecab);
const char* mecab_sparse_tostr(mecab_t *mecab, const char *str);
DEF;

    private FFI $libmecab;

    private ?FFI\CData $mecab = null;

    /**
     * @param string $libmecabPath Path for the libmecab DLL.
     * @param string[] $args Arguments for the mecab command. Please see the MeCab documentation for details.
     */
    public function __construct(string $libmecabPath, array $args = [])
    {
        $this->libmecab = FFI::cdef(self::C_DEF, $libmecabPath);

        $argc = count($args);
        if ($argc === 0) {
            $this->mecab = $this->libmecab->mecab_new2('');
        } else {
            $argv = FFI::new(FFI::arrayType(FFI::type('char *'), [$argc]));
            $args = array_values($args);
            for ($i = 0; $i < $argc; $i++) {
                $argv[$i] = self::toCString($args[$i], false);
            }
            $this->mecab = $this->libmecab->mecab_new($argc, $argv);
            for ($i = 0; $i < $argc; $i++) {
                FFI::free($argv[$i]);
            }
        }

        if (!$this->mecab) {
            $err = $this->libmecab->mecab_strerror(null);
            throw new RuntimeException('failed to instantiate MeCab: ' . $err);
        }
    }

    public function __destruct()
    {
        if ($this->mecab) {
            $this->libmecab->mecab_destroy($this->mecab);
        }
    }

    public function version(): string
    {
        return $this->libmecab->mecab_version();
    }

    public function parse(string $text): string
    {
        return $this->libmecab->mecab_sparse_tostr($this->mecab, $text);
    }

    private static function toCString(string $str, bool $owned = true): FFI\CData
    {
        $len = strlen($str);
        $cString = FFI::new(sprintf('char[%d]', $len + 1), $owned);
        FFI::memcpy($cString, $str, $len);
        $cString[$len] = "\0";

        return $cString;
    }
}
