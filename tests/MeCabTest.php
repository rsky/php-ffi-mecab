<?php

namespace MeCab;

use PHPUnit\Framework\TestCase;
use RuntimeException;

class MeCabTest extends TestCase
{
    private MeCab $mecab;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $libmecabPath = getenv('LIBMECAB_PATH');
        if (empty($libmecabPath)) {
            static::markTestSkipped('environmental variable $LIBMECAB_PATH is not set');
        }
        if (!file_exists($libmecabPath)) {
            static::markTestSkipped('file $LIBMECAB_PATH does not exist');
        }

        $ipadicDir = getenv('MECAB_IPADIC_UTF8_DIR');
        if (!empty($ipadicDir) && !is_dir($ipadicDir)) {
            static::markTestSkipped('directory $MECAB_IPADIC_UTF8_DIR does not exist');
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $libmecabPath = getenv('LIBMECAB_PATH');
        $ipadicDir = getenv('MECAB_IPADIC_UTF8_DIR');
        if (empty($ipadicDir)) {
            // デフォルトのrcfileの内容でMeCabを初期化
            $this->mecab = new MeCab($libmecabPath);
        } else {
            // rcfileを無効にし、辞書だけを指定してMeCabを初期化
            $this->mecab = new MeCab($libmecabPath, ['-r', '', '-d', $ipadicDir]);
        }
    }

    public function testConstructFail(): void
    {
        $this->expectException(RuntimeException::class);

        new MeCab(getenv('LIBMECAB_PATH'), ['-r', '', '-d', __FILE__]);
    }

    public function testVersion(): void
    {
        $version = $this->mecab->version();

        $this->assertMatchesRegularExpression('/^0\\.9\\d+$/D', $version);
    }

    public function testParse(): void
    {
        $expected = <<<'HERE'
全て	名詞,副詞可能,*,*,*,*,全て,スベテ,スベテ
は	助詞,係助詞,*,*,*,*,は,ハ,ワ
猫	名詞,一般,*,*,*,*,猫,ネコ,ネコ
様	名詞,接尾,人名,*,*,*,様,サマ,サマ
の	助詞,連体化,*,*,*,*,の,ノ,ノ
ため	名詞,非自立,副詞可能,*,*,*,ため,タメ,タメ
に	助詞,格助詞,一般,*,*,*,に,ニ,ニ
EOS

HERE;

        $result = $this->mecab->parse('全ては猫様のために');

        $this->assertSame($expected, $result);
    }
}
