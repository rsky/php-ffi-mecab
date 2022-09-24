<?php

namespace MeCab;

class MeCabTest extends MeCabBaseTestCase
{
    public function testVersion(): void
    {
        $version = $this->createTagger()->version();

        $this->assertMatchesRegularExpression('/^0\\.9\\d+$/D', $version);
    }

    public function testWakati(): void
    {
        $text = '全ては猫様のために';
        $words = $this->createMeCab()->wakati($text);

        $this->assertSame([
            '全て',
            'は',
            '猫',
            '様',
            'の',
            'ため',
            'に',
        ], $words);
    }
}