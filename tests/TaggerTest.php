<?php

namespace MeCab;

use RuntimeException;

class TaggerTest extends MeCabBaseTestCase
{
    public function testConstructFail(): void
    {
        $this->expectException(RuntimeException::class);

        new Tagger(getenv('LIBMECAB_PATH'), ['-r', '', '-d', __FILE__]);
    }

    public function testVersion(): void
    {
        $version = $this->createTagger()->version();

        $this->assertMatchesRegularExpression('/^0\\.9\\d+$/D', $version);
    }

    public function testParse(): void
    {
        $text = '全ては猫様のために';
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

        $result = $this->createTagger()->parse($text);

        $this->assertSame($expected, $result);
    }

    public function testParseToNode(): void
    {
        $text = '全ては猫様のために';
        $node = $this->createTagger()->parseToNode($text);

        $this->assertInstanceOf(Node::class, $node);
    }
}
