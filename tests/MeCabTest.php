<?php

namespace MeCab;

class MeCabTest extends MeCabBaseTestCase
{
    private MeCab $mecab;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mecab = $this->createMeCab();
    }

    public function testVersion(): void
    {
        $version = $this->mecab->version();

        $this->assertMatchesRegularExpression('/^0\\.9\\d+$/D', $version);
    }

    public function testSplit(): void
    {
        $morphs = $this->mecab->split(self::SAMPLE_TEXT);

        $this->assertSame([
            '全て',
            'は',
            '猫',
            '様',
            'の',
            'ため',
            'に',
        ], $morphs);
    }
}
