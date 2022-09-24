<?php

namespace MeCab;

class MeCab
{
    private Tagger $tagger;

    /**
     * @param string $libmecabPath Path for the libmecab DLL.
     * @param string[] $args Arguments for the mecab command. Please see the MeCab documentation for details.
     */
    public function __construct(string $libmecabPath, array $args = [])
    {
        $this->tagger = new Tagger($libmecabPath, $args);
    }

    /**
     * Return a version string.
     */
    public function version(): string
    {
        return $this->tagger->version();
    }

    /**
     * テキストを形態素の配列に分解する
     *
     * @return string[]
     */
    public function split(string $text): array
    {
        $node = $this->tagger->parseToNode($text);
        $node = $node->next(); // Skip BOS
        $morphs = [];

        while ($node !== null && $node->stat() !== NodeStat::EOS) {
            $morphs[] = $node->surface();
            $node = $node->next();
        }

        return $morphs;
    }
}
