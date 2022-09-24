<?php

namespace MeCab;

use PHPUnit\Framework\TestCase;

abstract class MeCabBaseTestCase extends TestCase
{
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

    protected function createMeCab(): MeCab
    {
        $libmecabPath = getenv('LIBMECAB_PATH');
        $ipadicDir = getenv('MECAB_IPADIC_UTF8_DIR');
        if (empty($ipadicDir)) {
            // デフォルトのrcfileの内容で初期化
            return new MeCab($libmecabPath);
        } else {
            // rcfileを無効にし、辞書だけを指定して初期化
            return new MeCab($libmecabPath, ['-r', '', '-d', $ipadicDir]);
        }
    }

    protected function createTagger(): Tagger
    {
        $libmecabPath = getenv('LIBMECAB_PATH');
        $ipadicDir = getenv('MECAB_IPADIC_UTF8_DIR');
        if (empty($ipadicDir)) {
            // デフォルトのrcfileの内容で初期化
            return new Tagger($libmecabPath);
        } else {
            // rcfileを無効にし、辞書だけを指定して初期化
            return new Tagger($libmecabPath, ['-r', '', '-d', $ipadicDir]);
        }
    }
}
