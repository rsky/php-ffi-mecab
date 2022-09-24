<?php

namespace MeCab;

class LifetimeTest extends MeCabBaseTestCase
{
    /**
     * テスト用にTaggerを継承したTaggerForLifetimeのインスタンスを生成する
     */
    private function createTaggerForLifetime(): TaggerForLifetime
    {
        $libmecabPath = getenv('LIBMECAB_PATH');
        $ipadicDir = getenv('MECAB_IPADIC_UTF8_DIR');
        if (empty($ipadicDir)) {
            // デフォルトのrcfileの内容で初期化
            return new TaggerForLifetime($libmecabPath);
        } else {
            // rcfileを無効にし、辞書だけを指定して初期化
            return new TaggerForLifetime($libmecabPath, ['-r', '', '-d', $ipadicDir]);
        }
    }

    /**
     * Taggerをunsetして参照カウンタが減ってもNodeが利用できることを確認する
     * (Taggerがまだ生きていることを確認する)
     */
    public function testLifetimeSafe(): void
    {
        $tagger = $this->createTagger();
        $node = $tagger->parseToNode(self::SAMPLE_TEXT);
        unset($tagger);
        $this->assertSame(NodeStat::BOS, $node->stat());
    }

    /**
     * TaggerForLifetimeをunsetしたあとNodeをunsetしてTaggerForLifetimeのデストラクタが呼ばれることを確認する
     * (循環参照していないことを確認する)
     */
    public function testDestructorCalled(): void
    {
        $tagger = $this->createTaggerForLifetime();
        $node = $tagger->parseToNode(self::SAMPLE_TEXT);
        unset($tagger);
        $this->assertSame(NodeStat::BOS, $node->stat());
        $this->expectException(DebugException::class);
        $this->expectExceptionMessage('destructed!');
        unset($node);
    }
}
