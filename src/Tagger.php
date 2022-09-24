<?php

namespace MeCab;

use FFI;
use FFI\CData;
use MeCab\FFI\Util;
use MeCab\FFI\Header;
use RuntimeException;

class Tagger
{
    private FFI $libmecab;

    private ?CData $mecab;

    /**
     * @param string $libmecabPath Path for the libmecab DLL.
     * @param string[] $args Arguments for the mecab command. Please see the MeCab documentation for details.
     */
    public function __construct(string $libmecabPath, array $args = [])
    {
        $this->libmecab = FFI::cdef(Header::C_DEFINITION, $libmecabPath);

        $argc = count($args);
        if ($argc === 0) {
            $this->mecab = $this->libmecab->mecab_new2('');
        } else {
            $argv = FFI::new(FFI::arrayType(FFI::type('char *'), [$argc]));
            $args = array_values($args);
            for ($i = 0; $i < $argc; $i++) {
                $argv[$i] = Util::toCString($args[$i], false);
            }
            $this->mecab = $this->libmecab->mecab_new($argc, $argv);
            for ($i = 0; $i < $argc; $i++) {
                FFI::free($argv[$i]);
            }
        }

        if (!$this->mecab) {
            $err = $this->libmecab->mecab_strerror(null);
            throw new RuntimeException('failed to instantiate MeCab\\Tagger: ' . $err);
        }
    }

    public function __destruct()
    {
        if ($this->mecab) {
            $this->libmecab->mecab_destroy($this->mecab);
        }
    }

    /**
     * Return a version string.
     */
    public function version(): string
    {
        return $this->libmecab->mecab_version();
    }

    /**
     * Parse given sentence and return parsed result as string.
     */
    public function parse(string $text): string
    {
        return $this->libmecab->mecab_sparse_tostr($this->mecab, $text);
    }

    /**
     * Parse given sentence and return Node object.
     */
    public function parseToNode(string $text): Node
    {
        $node = $this->libmecab->mecab_sparse_tonode($this->mecab, $text);

        return new Node($this, $node);
    }
}
